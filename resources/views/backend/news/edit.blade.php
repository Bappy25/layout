@extends('backend.layouts.master')

@section('title')
All News || Edit News
@endsection

@section('extra-css')

<!-- Light Gallery Plugin Css -->
{{ Html::style('plugins/light-gallery/css/lightgallery.css') }}

<!-- Bootstrap Tagsinput Css -->
{{ Html::style('plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}

@endsection

@section('content')

<div class="block-header">
    <ol class="breadcrumb breadcrumb-col-teal">
        <li><i class="material-icons">rss_feed</i> News</li>
        <li><a href="{{ route('back.news.index') }}"><i class="material-icons">list</i> All News</a></li>
        <li class="active"><i class="material-icons">edit</i> Edit News</li>
    </ol>
</div>

<!--  Edit News Form -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Edit News
                    <small>
                        <strong>Created At:</strong> {{ $news->created_at->format('d/m/y, h:m a') }}
                        || <strong>Last Updated:</strong> {{ $news->updated_at->format('d/m/y, h:m a') }}
                    </small>
                </h2>
            </div>
            <div class="body">

                <div id="aniimated-thumbnials">
                    <a href="<?php echo file_exists($blog['image_path']) ? asset($blog['image_path']) : 'https://via.placeholder.com/300?text=Image+Missing'; ?>">
                        <?php echo image($blog['image_path'], $blog['title'], ['class'=>'img-responsive thumbnail']); ?>
                    </a>
                </div>
                <button type="button" class="btn bg-red waves-effect m-t-15" data-toggle="modal" data-target="#image_update_modal">Update Article Image</button>

                {!! Form::model($news, ['method' => 'put', 'route' => ['back.news.update', $news->id], 'name'=>'check_edit', 'id' => 'save_news_draft']) !!}

                <div class="form-group">
                    {!! Form::label("title") !!}
                    <div class="form-line">
                        {!! Form::textarea("title", null, ['class'=>'form-control no-resize auto-growth', 'rows'=>1, 'autocomplete'=>'off']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label("tags") !!}
                    <div class="form-line">
                        {!! Form::text("tags", null, ['class'=>'form-control', 'data-role' => 'tagsinput']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('description') !!}
                    <div class="form-line">
                        {!! Form::textarea("description", null, ['class'=>'tinymce']) !!}
                    </div>
                </div>

                <div class="button-demo">
                    {!! Form::button('<i class="material-icons">save</i><span>Update Draft</span>', ['class'=>'btn bg-teal waves-effect sub_button', 'type' => 'submit']) !!}
                    <button class="btn btn-primary waves-effect" type="submit">
                        <i class="material-icons">publish</i>
                        <span>Publish News</span>
                    </button>
                    <button class="btn btn-danger waves-effect" type="submit">
                        <i class="material-icons">delete</i>
                        <span>Delete News</span>
                    </button>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<!-- #END# Edit News Form -->

<div class="modal fade" id="image_update_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Update Article Image</h4>
                </div>
                <div class="modal-body">
                    <form method="post" id="image_update_form" action="<?php echo route('srms/blogs/update/image'); ?>" enctype="multipart/form-data">        
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="hidden" name="id" value="<?php echo $blog['id']; ?>">
                        <div class="thumbnail">
                            <img src="http://via.placeholder.com/300x300?text=Preview+Selected+Image" alt="image update preview" class="img-responsive preview_input">
                            <div class="caption">
                                <div class="button-demo">
                                    <label class="btn btn-primary waves-effect" data-toggle="tooltip" data-placement="bottom" title="Click here to select an image">
                                        CHOOSE IMAGE <input type="file" name="image_path" accept="image/jpeg" class="input_image" style="display: none;" required/>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-link waves-effect image_update_button" type="submit" form="image_update_form" disabled>SAVE CHANGES</button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('extra-script')

<!-- Light Gallery Plugin Js -->
{{Html::script('plugins/light-gallery/js/lightgallery-all.js')}}

<!-- Autosize Js -->
{{Html::script('plugins/autosize/autosize.js')}}

<!-- Bootstrap Tags Input Plugin Js -->
{{Html::script('plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')}}

<!-- TinyMCE -->
{{Html::script('plugins/tinymce/tinymce.min.js')}}

<!-- Jquery Form Plugin Js -->
{{Html::script('plugins/jquery-form/jquery.form.js')}}

@endsection

@section('custom-script')

{{Html::script('js/backend/pages/medias/image-gallery.js')}}

<!-- Backend Script -->
{{Html::script('js/backend/script.js')}}

<script type="text/javascript">

    $(function () {

        autosize($('textarea.auto-growth'));

            // Save Draft
        $('#save_news_draft').ajaxForm({
          beforeSend: function() {
            $('.sub_button').prop('disabled', true);
          },
          complete: function(xhr) {
            data = JSON.parse(xhr.responseText);
            if(data.result == true){
                removeAlerts();
                showNotification(data.message, "", "#", "success", "bottom", "right", 20, 20, 'animated fadeInDown', 'animated fadeOutUp');
            }
            else{
                removeAlerts();
                showNotification(data.message, "", "#", "danger", "bottom", "right", 20, 20, 'animated fadeInDown', 'animated fadeOutUp');
                if(!jQuery.isEmptyObject(data.details)){
                    $.each(data.details, function( index, value ) {  
                        $("[name='"+index+"']").addClass("is-invalid");
                        $("[name='"+index+"']").parent().addClass("error focused");
                        $("[name='"+index+"']").parent().after('<label class="error" for="name">'+value+'</label>');
                    });
                }
            }
            $('.sub_button').prop('disabled', false); 
          }
        }); 

    });

    // Declare Tinymce
    tinymce.init({

        selector: "textarea.tinymce",
        height: 800,
        plugins: [
            'advlist autolink lists image code charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table directionality',
            'emoticons template paste textpattern imagetools',
        ],
        toolbar1: 'undo redo | image code| insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | print preview media | forecolor backcolor emoticons',
        setup: function (editor) {
            editor.on('change', function () {
                tinymce.triggerSave();
            });
        },
        image_advtab: true,

        images_upload_url: '/add_content_image',

        images_upload_handler: function (blobInfo, success, failure) {

            var xhr, formData;
          
            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;

            xhr.open('POST', '/add_content_image');
          
            xhr.onload = function() {
                var json;
            
                if (xhr.status != 200) {
                    failure('HTTP Error: ' + xhr.status);
                    return;
                }
            
                json = JSON.parse(xhr.responseText);
            
                if (!json || typeof json.data.path != 'string') {
                    failure('Invalid JSON: ' + xhr.responseText);
                    return;
                }
            
                success(window.location.origin+'/'+json.data.path);
            };
          
            formData = new FormData();
            formData.append('upload_image', blobInfo.blob(), blobInfo.filename());
            formData.append('folder','editors');
            formData.append('size','500');
            formData.append('_token', $('meta[name=csrf-token]').attr('content'));
          
            xhr.send(formData);
        }

    });

    tinymce.suffix = ".min";
    tinyMCE.baseURL = '../../../plugins/tinymce';

        // Prevent Leave
    window.addEventListener('beforeunload', function(e) {
      var myPageIsDirty = tinymce.activeEditor.isDirty()
      if(myPageIsDirty) {
        e.preventDefault(); //per the standard
        e.returnValue = ''; //required for Chrome
      }
    });

    function removeAlerts(){
        $.each($('input,select,textarea', '#save_news_draft'),function(k){
            $(this).removeClass("is-invalid");
            $(this).parent().removeClass("error focused");
            $(this).parent().next('label').remove();
        });
    }

</script>

@endsection