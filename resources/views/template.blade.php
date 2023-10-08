@include('partials.headers')
@include('partials.topnav')

        @include('partials.sidenav')
            <div id="layoutSidenav_content">
                <main>
                    @yield('content')
                </main>
                @include('partials.footer')
