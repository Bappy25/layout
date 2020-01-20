@if (session('info'))
@foreach(session('info') as $title => $message)
<div class="alert alert-info alert-dismissible"> 
  <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>{{ $title }}</strong>&nbsp;{{ $message }}
</div>
@endforeach
@endif
@if (session('success'))
@foreach(session('success') as $title => $message)
<div class="alert alert-success alert-dismissible"> 
  <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>{{ $title }}</strong>&nbsp;{{ $message }}
</div>
@endforeach
@endif
@if (session('error'))
@foreach(session('error') as $title => $message)
<div class="alert alert-error alert-dismissible"> 
  <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>{{ $title }}</strong>&nbsp;{{ $message }}
</div>
@endforeach
@endif
@if (session('warning'))
@foreach(session('warning') as $title => $message)
<div class="alert alert-warning alert-dismissible"> 
  <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>{{ $title }}</strong>&nbsp;{{ $message }}
</div>
@endforeach
@endif