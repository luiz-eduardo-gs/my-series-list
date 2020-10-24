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
    <div class="container">
        <header>
            <h1>MySeriesList</h1>
            <p>Vendo <b>Sua</b> Lista de Séries</p>
        </header>
        <main>
            <section class="box main_header">
                <div>
                    <img alt="Imagem da logo principal" src="{{ URL::asset('static/images/main-logo.png') }}">
                </div>
                <div id="nav_status">
                    <ul>
                        <li><a href="/series">Todas as séries</a></li>
                        <li><a href="/series?status=A">Assistindo</a></li>
                        <li><a href="/series?status=C">Completas</a></li>
                        <li><a href="/series?status=P">Planejo Assistir</a></li>
                    </ul>
                </div>
            </section>
            @yield('main')
        </main>
        <!-- <footer>
        <p>MySeriesList.exp is a property of MySeriesList Co.,Ltd. ©2020 All Rights Reserved.</p>
    </footer> -->
    </div>
</body>

</html>