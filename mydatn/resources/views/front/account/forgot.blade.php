@extends('front.layout.master')
@section('title', 'Product Detail')

@section('body')

<div class="account section">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-6">
				<div class="login-form border p-5">
					<div class="text-center heading">
						<h3 class="mb-2 h2">Password Recovery</h3>
						<p class="lead">Please enter the email address for your account. A verification code will be sent to you. Once you have received the verification code, you will be able to choose a new password for your account.</p>
					</div>

					<form action="" method="POST">
            @csrf
						<div class="form-group mb-4">
							<label for="#">Enter Email Address</label>
              {{-- thông báo --}}
              @if(session('notification'))
                <div class="alert alert-warning" role="alert">
                  {{ session('notification')}}
                </div>
              @endif
							<input type="text" class="form-control" name="email" placeholder="Enter Email Address">
						</div>
						{{-- <a href="#" class="btn btn-main mt-3 btn-block">Request OTP</a> --}}
            			<button type="submit" value="submit" class="btn btn-main mt-3 btn-block">Request OTP</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>


@endsection
