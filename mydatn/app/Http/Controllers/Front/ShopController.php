<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductComment;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function show($id, Request $request){
        
        //findOrFail truy xuất 1 bản ghi theo id
        $product = Product::findOrFail($id);


        $avgRating = 0;
        //bien luu tong sao xep hang
        //tính tổng các rating trong productComments vì 1 product có nhiều cmt nên nó thuộc kiểu array
        $sumRating = array_sum(array_column($product->productComments->toArray(),'rating'));
        //bien luu so luong xep hang
        $countRating = count($product->productComments);
       // loai bo truong hop chia cho 0(ko co xep hang nao)
        $id = $product->id;
        $comments = ProductComment::leftJoin('products', 'products.id', '=', 'product_comments.product_id')
                        ->where('product_comments.product_id',$id)             
                        ->where('status',1)->get();
        $comment = ProductComment::all();
        //dd($comments);
        // if ($countRating != 0){
        //     //tinh trung binh xep hang
        //     $avgRating = $sumRating/$countRating;
        // }
        $user = $request->session()->get('customer');
        if($user){
            $checkComment = Order::leftJoin('order_details', 'orders.id', '=', 'order_details.order_id')
            ->where('order_details.product_id',$id)
            ->where('orders.user_id',$user->id)->count();
        }else{
            $checkComment = 0;
        }
       
        //dd($checkComment);
        //lấy dữ liệu danh sách sp cung loai,cùng nhãn sp hiện tại
        //cùng loại sp product_category_id
        //gioi han 4 ban ghi duoc lay
        //sử dụng phương thức get để lấy dữ liệu
        $productColors = Product::leftJoin('product_details','products.id','product_details.product_id')
                                ->where('products.id',$id)
                                ->groupBy('product_details.color')->get();

        $productSizes = Product::leftJoin('product_details','products.id','product_details.product_id')
                                ->where('products.id',$id)
                                ->where('product_details.color',$productColors[0]['color'])
                                ->groupBy('product_details.size')->orderBy('product_details.id','asc')->get();
    

        $relatedProducts = Product::where('product_category_id',$product->product_category_id)
                                    ->where('tag',$product->tag)
                                    ->limit(4)->get();
        
        return view('front.shop.show', compact('product','productSizes','productColors','relatedProducts','comments','checkComment'));
        // return view('front.shop.show', compact('product', 'avgRating','relatedProducts','checkComment','productSizes','productColors','comments','user'));
    }
    public function changeColor(Request $request){
        if($request->ajax()){
            $color = $request->color;
            $product_id = $request->product_id;
            $listSize = Product::leftJoin('product_details','products.id','product_details.product_id')
                                ->where('product_details.color',$color)
                                ->where('products.id',$product_id)->get();
            $htmlSize = '<span style="margin-right:88px" class="font-weight-bold text-capitalize product-meta-title">Size:</span>';
            foreach ($listSize as $key => $value) {
                $check = ($key==0)? "checked" : "";
                $class = ($key==0)? "product-size-active" : "";
                $htmlSize .='<div class="sc-item">';
                $htmlSize .=    '<input '.$check.' type="radio" id="sm-'.$value['size'].'" name="size" value="'.$value['size'].'">';
                $htmlSize .=    '<label class="size '.$class.'" for="sm-'.$value['size'].'">'.$value['size'].'</label>';
                $htmlSize .='</div>';
            }
            $result['htmlSize'] = $htmlSize;
            return response()->json($result);
        }
    }

    //them phuong thuc post
    public function postComment(Request $request){
        //thêm tất cả dữ liệu vào bảng productComment
        ProductComment::create($request->all());

        //quay lai trang truoc(chi tiet san pham)
        return redirect()->back()->with('notification', 'Bình luận của bạn phải được kiểm duyệt trước khi hiển thị.');
    }

    public function index(Request $request){

        //get categories,brand
        //$categories = ProductCategory::all();
        $categories = ProductCategory::where('parent_id',0)->get();
        $brands = Brand::all();

        //Lấy dữ liệu số sp mỗi trang bằng request nếu số giá trị ko null thì mặc định là 6(show là tên name)
        $perPage = $request->show ?? 6;
        $sortBy = $request->sort_by ?? 'latest';
        //Lấy dữ liệu từ khóa tìm kiếm = request
        $search = $request->search ?? '';

        //lấy danh sách sp theo từ khóa tìm kiếm
        $products = Product::where('name','like','%' . $search . '%')->where('inventory','>',0);
        //sửa lại trường hợp sắp xếp theo các sp vừa tìm kiếm

        $products = $this->locsp($products, $request);
        
        $products = $this->sapxep($products, $sortBy, $perPage);
        return view('Front.shop.index', compact('products','categories','brands'));
    }

    public function category($categoryName , Request $request){
        //get categories,brand
        //$categories = ProductCategory::all();
        $categories = ProductCategory::where('parent_id',0)->get();
        $brands = Brand::all();

        //Lấy dữ liệu số sp mỗi trang bằng request nếu số giá trị ko null thì mặc định là 6(show là tên name)(từ file index)
        $perPage = $request->show ?? 6;
        $sortBy = $request->sort_by ?? 'latest';

        //lấy ds sp theo danh mục
        //name =  categoryName = /shop/categoryName(routes)
        $products = ProductCategory::where('name', $categoryName)->first()->products->toQuery();

        //$products = $this->locsp($products, $request);

        $products = $this->sapxep($products, $sortBy, $perPage);

        return view('Front.shop.index', compact('products','categories','brands'));

    }

    public function sapxep($products, $sortBy, $perPage){
        //xử lí các trường hợp sắp xếp

        //sửa lại trường hợp sắp xếp theo các sp vừa tìm kiếm
        //ta trỏ từ file products để lọc
        //chú ý ở name search value={{ request('search')}} nếu ko có tại input search sẽ bị xóa mỗi lần tải trang
        //sắp xếp sẽ ko hoạt động
        switch($sortBy){
            case 'latest':
                //$products = Product::orderBy('id');
                $products = $products->orderByDesc('id');
                break;
            case 'oldest':
                $products = $products->orderBy('id');
                break;
            case 'name-ascending':
                $products = $products->orderBy('name');
                break;
            case 'name-descending':
                $products = $products->orderByDesc('name');
                break;
            case 'price-ascending':
                $products = $products->orderBy('price');
                break;
            case 'price-descending':
                $products = $products->orderByDesc('price');
                break;
            default:
                $products = $products->orderBy('id');

            
        }
        //phân trang với mỗi trang chỉ có 9sp(paginate)
        $products = $products->paginate($perPage);

        $products->appends(['sort_by' => $sortBy , 'show' => $perPage]);

        return $products;
    }

    // public function locsp($products, Request $request){
    //     //định nghĩa hàm brand
    //     $brands = $request->brand ?? [];
    //     $brand_ids = array_keys($brands);
    //     //toán tử 3 ngôi
    //     $products = $brand_ids != null ? $products->whereIn('brand_id', $brand_ids) : $products;

    //     return $products;
    // }
}
