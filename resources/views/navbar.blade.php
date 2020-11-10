<div class="bs-example">
    <nav class="navbar navbar-expand-md navbar-light bg-light">
        <a href="{{ route('roles.index')}}" class="navbar-brand">Laravel Traning</a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav">
                <a href="{{ route('roles.index')}}" class="nav-item nav-link @if(Route::current()->uri() == "roles") active @endif">Role</a>
                <a href="{{ route('students.index')}}" class="nav-item nav-link @if(Route::current()->uri() == "students") active @endif ">Students / Teachers</a>
            </div>
            <div class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    @php
                        if (Session::get('user_data'))
                        {
                            $message = Session::get('user_data')['name'];
                        }
                    @endphp
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">@php echo $message; @endphp</a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="/logout"class="dropdown-item">Logout</a>
                    </div>
                </li>
            </div>
        </div>
    </nav>
</div>
