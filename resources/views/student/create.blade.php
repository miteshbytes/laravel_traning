<!DOCTYPE html>
<html>
	<head>
		<title>Student - Laravel Traning</title>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css"/>
		<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="card bg-light mt-3">
				<div class="card-header">
					Student Insertion
					@if ($message = Session::get('success'))
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						{{ $message }}
					</div>
					@endif
				</div>
				<div class="card-body">
					<form action="@if(isset($user)) {{route('students.update', $user->id)}} @else {{ route('students.store') }} @endif" method="post" enctype="multipart/form-data">
						@csrf
						@if(isset($user))
						    @method('PUT')
						@endif
						<div class="form-group">
							<label for="name">Name *</label>
							<input type="text" class="form-control" name="name" id="name" value="{{ old('name', @$user->name) }}">
							@error('name')
							<span style="color: red">{{ $message }}</span>
							@endif
						</div>
						<div class="form-group">
							<label for="email">Email address *</label>
							<input type="email" class="form-control" name="email" id="email" value="{{ old('email', @$user->email) }}" @if(@$user->email) ?: readonly @endif>
							@error('email')
							<span style="color: red">{{ $message }}</span>
							@endif
						</div>
						<div class="form-group">
							<label for="gender">Gender *</label>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="male"  @if(old('gender', @$user->gender) ==  'male') checked="checked" @endif>
								<label class="form-check-label" for="inlineRadio1">Male</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="female" @if(old('gender', @$user->gender) ==  'female') checked="checked" @endif>
								<label class="form-check-label" for="inlineRadio2">Female</label>
							</div>
							@error('gender')
							<span style="color: red">{{ $message }}</span>
							@endif
						</div>
						<div class="row">
							<div class="col-6 col-md-6">
								<div class="form-group">
									<label for="date">Birth Date *</label>
									<input type="text" class="form-control date" name="birth_date" id="birth_date" autocomplete="off" value="{{ old('birth_date', @date('d-m-Y', strtotime($user->birth_date))) }}">
									@error('birth_date')
									<span style="color: red">{{ $message }}</span>
									@endif
								</div>
                            </div>
                            <div class="col-6 col-md-6">
								<div class="form-group">
                                    <label for="image">Profile Image</label>
                                    <input type="file" class="form-control-file" id="image" name="image">
                                    @error('image')
                                    <span style="color: red">{{ $message }}</span>
                                    @endif
                                    @if(Route::currentRouteName() == "students.edit")
                                        <img src="{{ asset('storage/'.$user->image)}}" class="img-thumbnail" width="100" />
                                    @endif
                                </div>
							</div>
						</div>
						<div class="form-group">
							<label for="Select Status">Select Role *</label>
							<select class="form-control" id="role" name="role">
								<option value="">Select role</option>
								@foreach($roles as $role)
                                <option value="{{$role->id}}" {{ old('role', @$user->role_id) == $role->id ? 'selected' : '' }}>{{$role->role_name}}</option>
                                @endforeach
							</select>
							@error('role')
							<span style="color: red">{{ $message }}</span>
							@endif
						</div>
						@php
							if(Route::currentRouteName() == "students.create")
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
	<script type="text/javascript">
	$('.date').datepicker({
	format: 'dd-mm-yyyy',
	autoclose: true,
	orientation: "bottom auto",
	endDate: '+0d',
	});
	</script>
</html>
