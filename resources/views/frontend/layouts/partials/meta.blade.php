<meta name="keywords" content="{{ $keywords }}"/>
<meta name="description" content="{{ substr($description, 0, 20).'...' }}">
<meta name="author" content="{{ $author }}">

<meta name="og:title" content="{{ $title }}"/>
<meta name="og:type" content="{{ $type }}"/>
<meta name="og:url" content="{{ url()->current() }}"/>
<meta name="og:image" content="{{ $image }}"/>
<meta name="og:site_name" content="{{ config('app.name') }}"/>
<meta name="og:description" content="{{ substr($description, 0, 20).'...' }}"/>