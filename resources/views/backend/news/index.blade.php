@extends('backend.layouts.master')

@section('title')
All News
@endsection

@section('extra-css')

<!-- Bootstrap Tagsinput Css -->
{{ Html::style('plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}

@endsection

@section('content')

<div class="block-header">
    <ol class="breadcrumb breadcrumb-col-teal">
        <li><i class="material-icons">rss_feed</i> News</li>
        <li class="active"><i class="material-icons">list</i> All News</li>
    </ol>
</div>

<!-- All News Table -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    All News
                    <small>Here is the list of all news</small>
                </h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>TITLE</th>
                                <th>AUTHOR</th>
                                <th>STATUS</th>
                                <th>VIEWS</th>
                                <th>CREATED AT</th>
                                <th>ACTION</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>TITLE</th>
                                <th>AUTHOR</th>
                                <th>STATUS</th>
                                <th>VIEWS</th>
                                <th>CREATED AT</th>
                                <th>ACTION</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($all_news as $news)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $news->title }}</td>
                                <td>{{ $news->admin->name }}</td>
                                <td>@if($news->status == 0) <span class="label label-warning">Saved to draft!</span> @else <span class="label label-info">Published!</span> @endif</td>
                                <td>{{ count((array)json_decode($news->viewers)) }}</td>
                                <td>{{ $news->created_at->format('d/m/y, h:m a') }}</td>
                                <td>
                                    {!! Form::open(['route' => ['back.news.destroy', $news->id], 'method'=>'delete']) !!}
                                    <a class="btn btn-warning" href="{{route('back.news.edit', $news->id)}}" title="Edit News"><i class="material-icons">edit</i></a>
                                    {!! Form::button('<i class="material-icons">delete</i>', array('class' => 'btn btn-danger form_warning_sweet_alert', 'title'=>'Delete News', 'text'=>'Once deleted the news cannot be restored', 'confirmButtonText'=>'Yes!', 'type'=>'submit')) !!}
                                    {!! Form::close() !!}
                                </td>
                                <td>{{ $news->tags }}</td>
                                <td>{{ $news->admin->email }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- #END# All News Table -->
@endsection

@section('extra-script')

<!-- Jquery DataTable Plugin Js -->
{{Html::script('plugins/jquery-datatable/jquery.dataTables.js')}}
{{Html::script('plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}
{{Html::script('plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}
{{Html::script('plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}
{{Html::script('plugins/jquery-datatable/extensions/export/jszip.min.js')}}
{{Html::script('plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}
{{Html::script('plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}
{{Html::script('plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}
{{Html::script('plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}

@endsection

@section('custom-script')

<!-- Backend Script -->
{{Html::script('js/backend/script.js')}}

<script type="text/javascript">

    $(document).ready(function(){
        var data_table = $('.js-basic-example').DataTable({
            "columnDefs": [
                {
                    "targets": [ 7 ],
                    "visible": false
                },
                {
                    "targets": [ 8 ],
                    "visible": false
                }
            ]
        });
    });
    
</script>

@endsection