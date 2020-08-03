@extends('frontend.layouts.master')

@section('title')
{{ $user->name }} || Notifications
@endsection

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $user->name }}</div>
                <div class="card-body">
                    <h5><i class="fas fa-bell mr-2"></i>Notifications</h5>
                    @if(count($user->unreadNotifications) > 0)
                    <div class="form-check ml-3 my-3" id="mark_all_as_read" data-url="{{ route('notifications.mark.read') }}">
                        <input type="checkbox" class="form-check-input" name="condition" id="mark_all_notifications_as_read">
                        <label class="form-check-label" for="mark_all_notifications_as_read">Mark Unread Notifications As Read</label>
                    </div>
                    @endIf
                    @foreach($notifications as $notification)
                    <a href="{{ $notification->data['link'] }}" class="link-unstyled">
                        <div class="rounded shadow-sm py-3 px-3 my-3 {{ is_null($notification->read_at) ? 'bg-info' : 'bg-default' }}">
                            <p class="{{ is_null($notification->read_at) ? 'text-light'  : '' }}">{{ $notification->data['text'] }}</p>
                            <small class="{{ is_null($notification->read_at) ? 'text-white-50'  : '' }}">{{ date('l, d F Y', strtotime($notification->created_at)) }}</small>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@if(count($user->unreadNotifications) > 0)
@section('custom-script')

<script>

    $(document).ready(function() {

        // Clear read notifications
        $('#mark_all_notifications_as_read').change(function() {
            if(this.checked) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                    }
                });
                $.ajax({
                    url: $("#mark_all_as_read").data('url'),
                    type: 'PUT',
                    beforeSend: function(){
                        $("#mark_all_notifications_as_read").prop('disabled', true);
                    },
                    success:function(response){
                        if(response.result == true){
                            $("#markasread").hide();
                            $("#new_notification_number").empty().append('0');
                            location.reload();
                        }
                        else{
                            console.log(response);
                        }
                    }
                });
            }
        });

    });

</script>

@endsection
@endIf