<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>{{ $data['title'] ? $data['title'] : "BookMyPlayer" }}</title>
<meta name="description" content="{{ $data['des'] }}">
<?php if (!empty($data['keywords'])) { ?>
<meta name="keywords" content="{{ $data['keywords'] }}">
<?php } ?>
<meta name="author" content="BookMyPlayer.com">
<meta name="robots" content="index, follow">
<meta http-equiv="cache-control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="expires" content="0">
<link rel="canonical" href="{{ isset($data['url']) ? $data['url'] : 'https://www.bookmyplayer.com' }}">

<meta data-n-head="ssr" data-hid="twitter:title" name="twitter:title" content="{{ $data['title'] }}">
<meta data-n-head="ssr" data-hid="twitter:description" name="twitter:description" content="{{ $data['des'] }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="shortcut icon" type="image/x-icon" href="{{env('AWS_CF_BASE_URL') }}/asset/images/fav.svg}}">
<link rel="icon" type="image/x-icon" href="{{ env('AWS_CF_BASE_URL') }}/asset/images/fav.svg">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('asset/css/admin/menu_v3.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('asset/css/admin/common_v2.css') }}" type="text/css">
<!-- Google tag (gtag.js) event -->
<script>
  gtag('event', 'ads_conversion_Form_1', {
    // <event_parameters>
  });
</script>

<!-- Facebook Lead Tracking -->
<script>
fbq('track', 'Lead');
</script>
<!-- End Facebook Lead Tracking -->
