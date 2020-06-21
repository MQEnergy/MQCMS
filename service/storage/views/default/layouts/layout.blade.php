@include(env('APP_WEB_TEMP', 'default') . '.layouts.header')

<section>
    @yield('content')
</section>

@include(env('APP_WEB_TEMP', 'default') . '.layouts.footer')