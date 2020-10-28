@extends('main_layout')

@section('title')
Página inicial
@endsection

@section('css')
<link rel="stylesheet" href="{{ URL::asset('static/css/bootstrap.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('static/css/index.css') }}" />
@endsection

@section('header')
<h1>MySeriesList</h1>
<p>Vendo <b>Sua</b> Lista de Séries</p>
@endsection

<a id="add_serie_button" href="/series/create"><button>+</button></a>

@section('main')
@if (Session::has('success'))
<div class="alert alert-success">
  {{ Session::get('success') }}
</div>
@endif

@if (Session::has('error'))
<div class="alert alert-danger">
  {{ Session::get('error') }}
</div>
@endif
<section class="box main_header">
  <div>
    <img alt="Imagem da logo principal" src="{{ URL::asset('static/images/main_logo.png') }}">
  </div>
  <div id="nav_status">
    <ul>
      <li><a href="/series">Todas as séries</a></li>
      <li><a href="/series?status=A">Assistindo</a></li>
      <li><a href="/series?status=C">Completas</a></li>
      <li><a href="/series?status=P">Planejo Assistir</a></li>
      <li><a href="/series?status=D">Dropadas</a></li>
    </ul>
  </div>
</section>
<section class="box">
  <div id="list_header">
    <h4 class="box">
      <?php 
        switch ($status[0]) {
          case "P":
            echo strtoupper('Planejo Assistir');
            break;
          case "C":
            echo strtoupper('Completas');
            break;
          case "A":
            echo strtoupper('Assistindo');
            break;
          case "D":
            echo strtoupper('Dropadas');
            break;
          default: echo strtoupper('Todas as séries');
        }
      ?>
    </h4>
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
        <?php $count = 0; ?>
        @foreach($series as $serie)
        <tr>
          <?php
          $color = "";
          switch ($serie->serie_status) {
            case "P":
              $color = "gray";
              break;
            case "C":
              $color = "blue";
              break;
            case "D":
              $color = "#7a1717";
              break;
            default:
              $color = "green";
          }
          ?>
          <td style="background-color: {{$color}};"><?php echo ++$count ?></td>
          <td>
            @if(!empty($serie->serie_image))
            <img alt="Imagem da série {{ $serie->serie_name }}" src="{{ URL::asset('static/images/uploads/' .$serie->serie_image) }}" />
            @else
            <img alt="Imagem da série {{ $serie->serie_name }}" src="{{ URL::asset('static/images/no_image.jpg') }}" />
            @endif
          </td>
          <td id="td_name_{{$serie->id}}">
            <div hidden id="edit_name_{{$serie->id}}">
              <input type="text" value="{{ $serie->serie_name }}">
              <div>
                <button onclick="editName({{$serie->id}})" class="btn btn-primary">
                  {!! file_get_contents('static/icons/check.svg') !!}
                </button>
              </div>
              @csrf
            </div>
            <a id="serie_name_{{$serie->id}}" href="/series/{{ $serie->id }}/seasons">{{ $serie->serie_name }}</a>
          </td>
          <td>0.0</td>
          <td>
            <form method="POST" action="/series/{{$serie->id}}/updateStatus" id="form_status_{{$serie->id}}">
              @csrf
              <span id="span_status_{{$serie->id}}">{{ $serie->serie_status }}</span>
              <a hidden id="link_status_{{$serie->id}}" onclick="addSelect('{{$serie->id}}', '{{$serie->serie_status}}', ['A', 'C', 'P', 'D'], 'form_status')">
                {{ $serie->serie_status }}
              </a>
            </form>
          </td>
          <td>
            <button onclick="toggleEdit({{$serie->id}})" class="btn btn-primary btn-sm">{!! file_get_contents('static/icons/edit.svg') !!}</button>
            <form method="POST" action="/series/{{ $serie->id }}">
              @csrf
              @method('DELETE')
              <button onclick="return confirm('Tem certeza que deseja excluir a {{ addslashes($serie->serie_name) }}?')" class="btn btn-danger btn-sm">
                {!! file_get_contents('static/icons/remove.svg') !!}
              </button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</section>

<script>
  function toggleEdit(serieId) {
    let tdNameDiv = document.querySelector(`#td_name_${serieId} > div`);
    let tdNameLink = document.querySelector(`#td_name_${serieId} > a`);
    if (tdNameDiv.hidden == true) {
      tdNameDiv.classList.add('edit_name');
      tdNameDiv.hidden = false;
      tdNameLink.hidden = true;
      document.getElementById(`link_status_${serieId}`).hidden = false;
      document.getElementById(`span_status_${serieId}`).hidden = true;
    } else {
      tdNameDiv.classList.remove('edit_name');
      tdNameDiv.hidden = true;
      tdNameLink.hidden = false;
      document.getElementById(`link_status_${serieId}`).hidden = true;
      document.getElementById(`span_status_${serieId}`).hidden = false;
    }
  }

  function editName(serieId) {
    let formData = new FormData();
    const newSerieName = document.querySelector(`#edit_name_${serieId} > input`).value;
    const token = document.querySelector('input[name="_token"]').value;

    formData.append('new_serie_name', newSerieName);
    formData.append('_token', token);
    const url = `/series/${serieId}`;

    fetch(url, {
      body: formData,
      method: 'POST'
    }).then(() => {
      toggleEdit(serieId);
      document.getElementById(`serie_name_${serieId}`).textContent = newSerieName;
    });
  }

  function addSelect(id, current, status, formId) {
    var x = document.createElement('SELECT');
    x.setAttribute("id", `select_${formId}_${id}`);
    x.setAttribute("name", `new_value`);
    x.setAttribute("onchange", `submitForm('${formId}_${id}')`);
    document.getElementById(`${formId}_${id}`).appendChild(x);
    document.querySelector(`#${formId}_${id} > a`).hidden = true;
    for(let i of status) {
      var z = document.createElement("option");
      z.setAttribute("value", i);
      if (i == current) {
        z.selected = 'selected';
      }
      var t = document.createTextNode(i);
      z.appendChild(t);
      document.getElementById(`select_${formId}_${id}`).appendChild(z);
    }
  }

  function submitForm(id) {
    document.getElementById(`${id}`).submit();
  }
</script>
@endsection