$( window ).resize(function() {

    // Align footer on windows resize
    footerAlign();

});

$(document).ready(function(){

    // Align footer on windows resize
    footerAlign();

    // Get number of new notifications
    numberOfNewNotifications();
    
    // Get number of new messages
    numberOfNewMessages();

    // Set when the loading screen will stop
    setTimeout(function(){ 
        $('.page-loader-wrapper').fadeOut(); 
    }, 50);

    // hide button to scroll to top  
    $("#scrollToTopButton").hide();

    //  Check to see if the window is top if not then display button
    $(window).scroll(function(){
        if ($(this).scrollTop() > 200) {
            $("#scrollToTopButton").fadeIn();
        } else {
            $("#scrollToTopButton").fadeOut();
        }
    });

    //  Click event to scroll to top
    $("#scrollToTopButton").click(function(){
        $('html, body').animate({scrollTop : 0},800);
        return false;
    });

    // Declare Popover
    $(function () {
        $('[data-toggle="popover"]').popover()
    });

    // Dropdown for new notifications
    $('#notifications_navigation_menu').on('show.bs.dropdown', function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: $("#all_new_notifications").data('url'),
            type: 'GET',
            dataType: 'JSON',
            beforeSend: function(){
                $("#all_new_notifications").empty().append('<div class="text-center my-5"><i class="fa fa-spinner fa-spin"></i></div>');
            },
            success:function(data){
                if(data.status == 200){
                    $("#all_new_notifications").empty();
                    $("#new_notification_number").empty().append(data.notifications.length);
                    if(data.notifications.length > 0){
                        $("#markasread").show();
                        $('#marknotificationasread').prop('disabled', false).prop('checked', false); 
                        html = '<div class="mx-3 my-3">';
                        if(data.notifications.length > 30){
                            html += 'You have more notifications! To read all notifications please click <a href="/notifications">here</a>!<hr>';
                        }
                        $.each(data.notifications, function( index, value ) {
                            html += '<a href="'+value.link+'" class="link-unstyled"><h6>'+value.text+'</h6></a><hr>';
                        }); 
                        html += '</div>';
                        $("#all_new_notifications").append(html);
                    }
                    else{
                        $("#all_new_notifications").empty().append('<div class="text-center my-5"><h5 class="font-weight-bold text-warning">No new notification found!</h5></div>');
                    }
                }
                else{
                    $("#all_new_notifications").empty().append('<div class="text-center my-5"><h5 class="font-weight-bold text-warning">Error: '+data.status+', '+data.reason+'</h5></div>');
                }
            }
        });
    });

    // Clear read notifications
    $('#marknotificationasread').change(function() {
        if(this.checked) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                }
            });
            $.ajax({
                url: $("#markasread").data('url'),
                type: 'GET',
                beforeSend: function(){
                    $("#marknotificationasread").prop('disabled', true);
                },
                success:function(){
                    $("#markasread").hide();
                    $("#new_notification_number").empty().append('0');
                    $("#new_notification_number").closest('.nav-link').removeClass('text-success');
                    showNotification("Success!", "The notifications are marked as read", "#", "success", "bottom", "left", 20, 20, 'animated fadeInDown', 'animated fadeOutUp'); 
                }
            });
        }
    });

    // Dropdown for new messages
    $('#messages_navigation_menu').on('show.bs.dropdown', function () {
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: $("#all_new_messages").data('url'),
            type: 'GET',
            dataType: 'JSON',
            beforeSend: function(){
                $("#all_new_messages").empty().append('<div class="text-center my-5"><i class="fas fa-spinner fa-spin"></i></div>');
            },
            success:function(data){
                if(data.status == 200){
                    $("#all_new_messages").empty();
                    $("#new_messages_number").empty().append(data.messages.length);
                    if(data.messages.length > 0){
                        $("#new_messages_number").closest('.nav-link').addClass('text-warning');
                        html = '<div class="mx-3 my-3">';
                        $.each(data.messages, function( index, value ) {
                            html += '<a href="'+value.link+'" class="link-unstyled"><h6>'+value.message+'</h6>';
                            html += '<small><strong><i class="fas fa-user mr-2"></i>'+value.user+'</strong><br>';
                            html += '<i class="fas fa-clock mr-2"></i>'+value.date+'</small></a><hr>';
                        }); 
                        html += '</div>';
                        $("#all_new_messages").append(html);
                    }
                    else{
                        $("#new_messages_number").closest('.nav-link').removeClass('text-warning');
                        $("#all_new_messages").empty().append('<div class="text-center my-5"><h5 class="font-weight-bold text-warning">No New Messages Found</h5></div>');
                    }
                }
                else{
                    $("#all_new_messages").empty().append('<div class="text-center my-5"><h5 class="font-weight-bold text-warning">Error: '+data.status+', '+data.reason+'</h5></div>');
                }
            }
        });
    });

});

// Function for aligning footer
function footerAlign() {
    $('footer').css('display', 'block');
    $('footer').css('height', 'auto');
    var footerHeight = $('footer').outerHeight();
    $('body').css('padding-bottom', footerHeight);
    $('footer').css('height', footerHeight);
}

// Function for getting new notifications number

function numberOfNewNotifications() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
        }
    });
    $.ajax({
        url: $("#new_notification_number").data('url'),
        type: 'GET',
        dataType: 'JSON',
        beforeSend: function(){
            $("#new_notification_number").empty().append('<i class="fas fa-spinner fa-spin"></i>');
        },
        success:function(data){
            if(data.status == 200){
                $("#new_notification_number").empty().append(data.count);
                if(data.count == 0){
                    $("#new_notification_number").closest('.nav-link').removeClass('text-warning');
                }
                else{
                    $("#new_notification_number").closest('.nav-link').addClass('text-warning');
                }
            }
            else{ 
                $("#new_notification_number").empty();
            }
        }
    });
}

// Function for getting new messages number

function numberOfNewMessages(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
        }
    });
    $.ajax({
        url: $("#new_messages_number").data('url'),
        type: 'GET',
        dataType: 'JSON',
        beforeSend: function(){
            $("#new_messages_number").empty().append('<i class="fas fa-spinner fa-spin"></i>');
        },
        success:function(data){
            if(data.status == 200){
                $("#new_messages_number").empty().append(data.count);
                if(data.count == 0){
                    $("#new_messages_number").closest('.nav-link').removeClass('text-warning');
                }
                else{
                    $("#new_messages_number").closest('.nav-link').addClass('text-warning');
                }
            }
            else{ 
                $("#new_messages_number").empty();
            }
        }
    });
}