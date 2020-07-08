<!-- Top Bar -->
<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="javascript:void(0);" class="bars"></a> <a class="navbar-brand" href="{{ route('back.home') }}">{{ config('app.name', 'Laravel') }} </a> </div>
            <div class="collapse navbar-collapse js-sweetalert" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- notifications -->
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" id="new-notifications-dropdown" data-toggle="dropdown" role="button">
                            <i class="material-icons">notifications</i>
                            <span class="label-count" id="new-notifications-count" data-url="javascript:void(0);"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">NOTIFICATIONS</li>
                        <div id="new-notifications-read" data-url="javascript:void(0);" style="display: none;">
                            <li>
                                <center style="margin-top: 10px;">
                                    <input type="checkbox" id="mark-notifications-as-read" class="chk-col-red"/>
                                    <label for="mark-notifications-as-read" class="col-red">Mark All As Read</label>
                                </center>
                            </li>
                            <li role="separator" class="divider"></li>
                        </div>
                            <li class="body">
                                <ul class="menu" id="new-notifications-show"></ul>
                            </li>
                            <li class="footer">
                                <a href="javascript:void(0);">View All Notifications</a>
                            </li>
                        </ul>
                    </li>
                    <!-- notifications -->
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
                </ul>
            </div>
        </div>
        <div class="nav-underLine"></div>
    </nav>
    <!-- #Top Bar -->
