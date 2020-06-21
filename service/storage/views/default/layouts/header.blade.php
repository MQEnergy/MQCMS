<!doctype html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="MQCMS应用开发框架">
    <title>MQCMS-@yield('title')</title>
    <link crossorigin="anonymous" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
          href="https://lib.baomitu.com/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link crossorigin="anonymous" integrity="sha384-K6LrEaceM4QP87RzJ7R4CDXcFN4cFW/A5Q7/fEp/92c2WV+woVw9S9zKDO23sNS+"
          href="https://lib.baomitu.com/Swiper/4.5.0/css/swiper.min.css" rel="stylesheet">
    <link href="https://cdn.bootcss.com/normalize/8.0.0/normalize.css" rel="stylesheet">
    <link crossorigin="anonymous" integrity="sha384-xI2vGALQzmd8MyNAdLvXhoojA5jmG3yET1XiRbtStkBZ/GwZaJXqUrFxNtOsRiGE"
          href="https://lib.baomitu.com/video.js/7.6.6/video-js.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/@php echo env('APP_WEB_TEMP', 'default'); @endphp/css/style.css">
    <script>
        var params, router, data;
        @if(isset($params))
        params = @php echo json_encode($params); @endphp;
        @endif
        @if(isset($router))
        router = "@php echo $router; @endphp";
        @endif
        @if(isset($data))
        data = @php echo json_encode($data); @endphp;
        @endif
    </script>
</head>
<body>

<header class="primary">
    {{-- logo --}}
    @include(env('APP_WEB_TEMP', 'default') . '.common.logo')
    {{-- Start nav --}}
    @include(env('APP_WEB_TEMP', 'default') . '.common.navbar')
</header>