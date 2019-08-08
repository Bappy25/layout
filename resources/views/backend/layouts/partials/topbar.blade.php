<!-- Top Bar -->
<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="javascript:void(0);" class="bars"></a> <a class="navbar-brand" href="{{ route('admin.home') }}">MDB Admin Panel</a> </div>
            <div class="collapse navbar-collapse js-sweetalert" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    @guest
                    <!--log in-->
                    <li class="dropdown">
                        <a href="javascript:void(0);" role="button" data-toggle="modal" data-target="#loginModal">
                            <i class="fa fa-sign-in" aria-hidden="true"></i>
                        </a>
                    </li>
                    <!--log in-->
                    @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="#">{{ __('Register') }}</a>
                    </li>
                    @endif
                    @else
                    <!--log out-->
                    <li class="dropdown">
                        <a href="{{ route('logout') }}" class="dropdown-toggle" onclick="logout()" role="button" data-type="logout">
                            <i class="material-icons">input</i>
                        </a>
                    </li>
                    <script>
                        function logout(){
                            event.preventDefault();
                            swal({
                                title: 'ログアウトしますか？',
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: "#d9534f",
                                confirmButtonText: 'ログアウト',
                                cancelButtonText: '戻る',
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
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <!--log out-->
                    @endguest
                </ul>
            </div>
        </div>
        <div class="nav-underLine"></div>
    </nav>
    <!-- #Top Bar -->
