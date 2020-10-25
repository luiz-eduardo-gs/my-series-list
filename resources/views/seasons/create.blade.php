@extends('main_layout')

@section('title')
Adicionar temporadas
@endsection

@section('css')
<link rel="stylesheet" href="{{ URL::asset('static/css/create.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('static/css/create_seasons.css') }}" />
@endsection

@section('header')
Adicionar temporadas
@endsection

@section('main')
@if($errors->any())
<div class="alert alert-danger">
    @foreach($errors->all() as $error)
    <ul>
        <li>{{$error}}</li>
    </ul>
    @endforeach
</div>
@endif
<section style="margin-top: 80px;" class="box">
    <form method="POST" action="/series/{{$serieId}}/seasons" enctype="multipart/form-data">
        @csrf
        <div class="text-center">
            <div>
                <label for="seasons_qt">Quantidade de temporadas</label><br>
                <input name="seasons_qt" id="seasons_qt" type="number">
            </div>
        </div>
        <button type="submit">Adicionar</button>
    </form>
</section>
@endsection