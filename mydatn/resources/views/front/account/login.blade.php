@extends('front.layout.master')
@section('title','Login')
@section('body')

<div class="account section">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-6">
				<div class="login-form border p-5">
					<div class="text-center heading">
						<h2 class="mb-2">Login</h2>
						<p class="lead">Don’t have an account? <a href="{{route('register')}}">Create a free account</a></p>
					</div>

          {{-- thông báo --}}
						@if(session('notification'))
            <div class="alert alert-warning" role="alert">
              {{ session('notification')}}
            </div>
          @endif

					<form method="POST" action="{{route('checkLogin')}}">
						@csrf 
						<div class="form-group mb-4">
							<label for="">Enter username</label>
							<input type="email" name="email" class="form-control" placeholder="Enter Username">
						</div>
						<div class="form-group">
							<label for="">Enter Password</label>
							<a class="float-right" href="{{route('forgot')}}">Forget password?</a>
							<input type="password" name="password" class="form-control" placeholder="Enter Password"> 
						</div>

						<button type="submit" value="submit" class="btn btn-main mt-3 btn-block">Login</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>


@endsection