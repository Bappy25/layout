<div class="block-header">
    <div class="block-header">
        <ol class="breadcrumb breadcrumb-col-teal">
            <li><i class="material-icons">verified_user</i> Administrators</li>
            @if($admin->exists)
            <li><a href="{{ route('back.admins.index') }}"><i class="material-icons">list</i> All Administrators</a></li>
            <li><a href="<?php echo route('srms/users/show', ['username' => $user['username']]); ?>"><i class="material-icons">open_in_browser</i> Show User</a></li>
            <li class="active"><i class="material-icons">edit</i> Edit Administrator</li>
            @else
            <li class="active"><i class="material-icons">playlist_add</i> Add New Administrator</li>
            @endif
        </ol>
    </div>
</div>