@extends('backend.layouts.master')

@section('title')
Welcome to Admin Panel
@endsection

@section('content')
<div class="block-header">
    <h2>DASHBOARD</h2>
</div>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header bg-green">
                <h2>
                    ADMIN PANEL HOME
                    <small>Welcome to admin panel</small>
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0);">Action</a></li>
                            <li><a href="javascript:void(0);">Another action</a></li>
                            <li><a href="javascript:void(0);">Something else here</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div>
                
            </div>
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-pink hover-expand-effect">
            <div class="icon">
                <i class="material-icons">people</i>
            </div>
            <div class="content">
                <div class="text">TOTAL USERS</div>
                <div class="number count-to" data-from="0" data-to="{{ $users }}" data-speed="15" data-fresh-interval="20"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-light-green hover-expand-effect">
            <div class="icon">
                <i class="material-icons">verified_user</i>
            </div>
            <div class="content">
                <div class="text">TOTAL ADMINISTRATORS</div>
                <div class="number count-to" data-from="0" data-to="{{ $admins }}" data-speed="1000" data-fresh-interval="20"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-cyan hover-expand-effect">
            <div class="icon">
                <i class="material-icons">rss_feed</i>
            </div>
            <div class="content">
                <div class="text">PUBLISHED NEWS</div>
                <div class="number count-to" data-from="0" data-to="{{ $news }}" data-speed="15" data-fresh-interval="20"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-orange hover-expand-effect">
            <div class="icon">
                <i class="material-icons">help</i>
            </div>
            <div class="content">
                <div class="text">UNPUBLISHED NEWS</div>
                <div class="number count-to" data-from="0" data-to="{{ $unpublished_news }}" data-speed="1000" data-fresh-interval="20"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra-script')

<!-- Jquery CountTo -->
{{Html::script('plugins/jquery-countto/jquery.countTo.js')}}

@endsection

@section('custom-script')

<!-- Backend Script -->
{{Html::script('js/backend/script.js')}}

<script type="text/javascript">

    $(function () {
        
        //Widgets count
        $('.count-to').countTo();
    
    });
    
</script>

@endsection
