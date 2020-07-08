<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <!-- User Info -->
    
    <div class="user-info">
        <div class="image">
            <img src="{{url('images/backend/user.png')}}" width="48" height="48" alt="User" />
        </div>
        <div class="info-container">
            <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{{ Auth::guard('admin')->user()->name }}}</div>
            <div class="email">{{{ Auth::guard('admin')->user()->email }}}</div>
            <div class="btn-group user-helper-dropdown">
                <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                <ul class="dropdown-menu pull-right">
                    <li><a href="javascript:void(0);"><i class="material-icons">person</i>Profile</a></li>
                    <li role="seperator" class="divider"></li>
                    <li><a href="{{ route('logout') }}" onclick="logout()"><i class="material-icons">input</i>Sign Out</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- #User Info -->
    <script>
        function logout(){
            event.preventDefault();
            swal({
                title: 'Are you sure you want to logout？',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: "#d9534f",
                confirmButtonText: 'Logout Now!',
                cancelButtonText: 'Cancel',
                closeOnConfirm: false,
                closeOnCancel: true
            },
            function(isConfirm){
                if (isConfirm) {
                    document.getElementById('logout-form').submit();
                } else {
                    // swal('Cancelled', 'You are still signed in!', 'info');
                }
            });
        }
    </script>
    <!-- Menu -->
    <div class="menu">
        <ul class="list">
            <li class="header">MAIN NAVIGATION</li>
            <li {{ Route::is('back.home')? 'class=active':'' }}>
                <a href="{{ route('back.home') }}">
                    <i class="material-icons">home</i>
                    <span>Home</span>
                </a>
            </li>
            <li {{ Route::is('admins*')? 'class=active':'' }}>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">verified_user</i>
                    <span>Administrators</span>
                </a>
                <ul class="ml-menu">
                    <li {{ Route::is('admins.index')? 'class=active':'' }}>
                        <a href="{{ route('admins.index') }}">All Administrators</a>
                    </li>
                    <li {{ Route::is('admins.create') || Route::is('admins.edit') ? 'class=active':'' }}>
                        <a href="{{ route('admins.create') }}">Add New Administrator</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">trending_down</i>
                    <span>Multi Level Menu</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a href="javascript:void(0);">
                            <span>Menu Item</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">
                            <span>Menu Item - 2</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <span>Level - 2</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="javascript:void(0);">
                                    <span>Menu Item</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="menu-toggle">
                                    <span>Level - 3</span>
                                </a>
                                <ul class="ml-menu">
                                    <li>
                                        <a href="javascript:void(0);">
                                            <span>Level - 4</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <!-- #Menu -->
    <!-- Footer -->
    <div class="legal">
        <div class="copyright">
            &copy; {{ date('Y') == 2019 ? date('Y') : '2019-'.date('Y') }} <a href="javascript:void(0);">AdminBSB - Material Design</a>.
        </div>
        <div class="version">
            <b>Version: </b> 1.0.5
        </div>
    </div>
    <!-- #Footer -->
</aside>
<!-- #END# Left Sidebar -->
