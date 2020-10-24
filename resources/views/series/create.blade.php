@extends('main_layout')

@section('title')
Adicionar série
@endsection

@section('css')
<link rel="stylesheet" href="{{ URL::asset('static/css/create.css') }}" />
@endsection

@section('body')
@if($errors->any())
<div class="alert alert-danger">
    @foreach($errors->all() as $error)
    <ul>
        <li>{{$error}}</li>
    </ul>
    @endforeach
</div>
@endif
<div class="container">
    <form method="POST" action="/series" enctype="multipart/form-data">
        @csrf
        <div class="d-flex justify-content-between">
            <div>
                <label for="name">Nome da série</label><br>
                <input name="serie_name" id="name" type="text">
            </div>
            <div>
                <label for="seasons_qt">Quantidade de temporadas</label><br>
                <input name="seasons_qt" id="seasons_qt" type="number">
            </div>
        </div>
        <label for="serie_image">Imagem</label>
        <input name="serie_image" id="serie_image" type="file">
        <br><br>
        <button type="submit">Adicionar</button>
    </form>
</div>
@endsection