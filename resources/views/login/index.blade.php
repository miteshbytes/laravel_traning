<!DOCTYPE html>
<html>
	<head>
		<title>Login - Laravel Traning</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	</head>
	<body>
		<div class="container">
			<div class="card bg-light mt-3">
				<div class="card-header">
					Login
                    @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ $message }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ $message }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
					@endif
				</div>
				<div class="card-body">
					<form action="{{ route('login.store') }}" method="post">
						@csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address *</label>
                            <input type="email" name="email" class="form-control" id="exampleInputEmail1" value="{{ old('email') }}">
                            @error('email')
							<span style="color: red">{{ $message }}</span>
							@endif
                          </div>
                          <div class="form-group">
                            <label for="exampleInputPassword1">Password *</label>
                            <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                            @error('password')
							<span style="color: red">{{ $message }}</span>
							@endif
                          </div>
						<button type="submit" class="btn btn-primary">Login</button>
					</form>
				</div>
			</div>

		</div>
	</body>
</html>
