<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>{{ $data['title'] ? $data['title'] : "BookMyPlayer" }}</title>
<meta name="description" content="{{ $data['des'] }}">
<?php if (!empty($data['keywords'])) { ?>
<meta name="keywords" content="{{ $data['keywords'] }}">
<?php } ?>
<meta name="author" content="BookMyPlayer.com">
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="cache-control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="expires" content="0">
<link rel="canonical" href="{{ isset($data['url']) ? $data['url'] : 'https://www.bookmyplayer.com' }}">
<meta data-n-head="ssr" data-hid="og:url" property="og:url" content="{{ isset($data['url']) ? $data['url'] : 'https://www.bookmyplayer.com' }}">
<meta data-n-head="ssr" data-hid="og:type" property="og:type" content="website">
<meta data-n-head="ssr" data-hid="og:title" property="og:title" name="og:title" content="{{ $data['title'] }}">
<meta data-n-head="ssr" data-hid="og:description" property="og:description" content="{{ $data['des'] }}">
<meta data-n-head="ssr" data-hid="twitter:card" name="twitter:card" content="summary_large_image">
<meta data-n-head="ssr" data-hid="twitter:site" name="twitter:site" content="@bookmyplayer">
<meta data-n-head="ssr" data-hid="twitter:creator" name="twitter:creator" content="@bookmyplayer">
<meta data-n-head="ssr" data-hid="twitter:title" name="twitter:title" content="{{ $data['title'] }}">
<meta data-n-head="ssr" data-hid="twitter:description" name="twitter:description" content="{{ $data['des'] }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="shortcut icon" type="image/x-icon" href="{{env('AWS_CF_BASE_URL') }}/asset/images/fav.svg}}">
<link rel="icon" type="image/x-icon" href="{{ env('AWS_CF_BASE_URL') }}/asset/images/fav.svg">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet' crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('asset/css/menu_v3.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('asset/css/common_v2.css') }}" type="text/css">
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-78EQNPZMJ1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'G-78EQNPZMJ1');
</script>
<!-- Google AW Tag -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-16631276068">
</script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-16631276068');
</script>
<!-- Meta Pixel Code -->
<script>!function (f, b, e, v, n, t, s) { if (f.fbq) return; n = f.fbq = function () { n.callMethod ? n.callMethod.apply(n, arguments) : n.queue.push(arguments) }; if (!f._fbq) f._fbq = n; n.push = n; n.loaded = !0; n.version = '2.0'; n.queue = []; t = b.createElement(e); t.async = !0; t.src = v; s = b.getElementsByTagName(e)[0]; s.parentNode.insertBefore(t, s) }(window, document, 'script', 'https://connect.facebook.net/en_US/fbevents.js'); fbq('init', '1130792818046296'); fbq('track', 'PageView');</script>
<noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id=1130792818046296&ev=PageView&noscript=1" /></noscript>
<!-- End Meta Pixel Code -->
