<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @yield('css')
    <link rel="stylesheet" href="{{ URL::asset('static/css/main.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('static/css/alerts.css') }}" />
</head>

<body>
    <nav class="nav_bar">
        <ul>
            <li><a href="/series" class="">Página inicial</a></li>
            <li><a href="/series/create" class="">Adicionar série</a></li>
        </ul>
    </nav>
    <div class="container clear">
        <header>
            @yield('header')
        </header>
        <main>
            @yield('main')
        </main>
        <!-- <footer>
        <p>MySeriesList.exp is a property of MySeriesList Co.,Ltd. ©2020 All Rights Reserved.</p>
    </footer> -->
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <script>
        (function($) {
            window.onbeforeunload = function(e) {
                window.name += ' [' + location.pathname + '[' + $(window).scrollTop().toString() + '[' + $(window).scrollLeft().toString();
            };
            $.maintainscroll = function() {
                if (window.name.indexOf('[') > 0) {
                    var parts = window.name.split('[');
                    window.name = $.trim(parts[0]);
                    if (parts[parts.length - 3] == location.pathname) {
                        window.scrollTo(parseInt(parts[parts.length - 1]), parseInt(parts[parts.length - 2]));
                    }
                }
            };
            $.maintainscroll();
        })(jQuery);
    </script>
</body>

</html>