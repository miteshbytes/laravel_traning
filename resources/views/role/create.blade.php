<!DOCTYPE html>
<html>
	<head>
		<title>Role - Laravel Traning</title>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css"/>
		<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="card bg-light mt-3">
				<div class="card-header">
					Role Insertion
					@if ($message = Session::get('success'))
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						{{ $message }}
					</div>
					@endif
				</div>
				<div class="card-body">
					<form action="@if(isset($role)) {{route('roles.update', $role)}} @else {{ route('roles.store') }} @endif" method="post">
						@csrf
						@if(isset($role))
						    @method('PUT')
						@endif
						<div class="form-group">
							<label for="name">Role Name*</label>
							<input type="text" class="form-control" name="role_name" id="role_name" value="{{ old('role_name', @$role->role_name) }}">
							@error('role_name')
							<span style="color: red">{{ $message }}</span>
							@endif
						</div>
						@php
							if(Route::currentRouteName() == "roles.create")
								$button = "Submit";
							else
								$button = "Update";
						@endphp
						<button type="submit" class="btn btn-primary">@php
							echo $button
                        @endphp</button>
                        @if($button == "Submit")
                            <button type="reset" class="btn btn-danger">Reset</button>
                        @endif
					</form>
				</div>
			</div>

		</div>
	</body>
</html>
