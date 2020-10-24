@extends('main_layout')

@section('title')
Página inicial
@endsection

@section('css')
<link rel="stylesheet" href="{{ URL::asset('static/css/bootstrap.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('static/css/index.css') }}" />
@endsection

@section('body')
<a id="add_serie_button" href="/series/create"><button>+</button></a>
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
        @if (Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
        @endif
        <section class="box">
            <div id="list_header">
                <h4 class="box">TODAS AS SÉRIES</h4>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Imagem</th>
                            <th>Nome da série</th>
                            <th>Nota</th>
                            <th>Status</th>
                            <th>Opções</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($series as $serie)
                            <td>1</td>
                            <td><img alt="Imagem da série {{ $serie->serie_name }}" src="{{ URL::asset('static/images/uploads/' .$serie->serie_image) }}" /></td>
                            <td><a href="#">{{ $serie->serie_name }}</a></td>
                            <td>10</td>
                            <td>A</td>
                            <td>
                                <button class="btn btn-primary btn-sm">{!! file_get_contents('static/icons/edit.svg') !!}</button>
                                <form method="POST" action="/series/{{ $serie->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Tem certeza que deseja excluir a {{ addslashes($serie->serie_name) }}?')" class="btn btn-danger btn-sm">
                                        {!! file_get_contents('static/icons/remove.svg') !!}
                                    </button>
                                </form>
                            </td>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</div>
<!-- <footer>
        <p>MySeriesList.exp is a property of MySeriesList Co.,Ltd. ©2020 All Rights Reserved.</p>
</footer> -->
@endsection