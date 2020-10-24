@extends('main_layout')

@section('css')
<link rel="stylesheet" href="{{ URL::asset('static/css/bootstrap.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('static/css/index.css') }}" />
@endsection

@section('main')
<section class="box">
  <div id="list_header">
    <h4 class="box">TEMPORADAS DE THE BIG BANG THEORY</h4>
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Imagem</th>
          <th>Nome da temporada</th>
          <th>Nota</th>
          <th>Nº episódios</th>
          <th>Progresso</th>
          <th>Opções</th>
        </tr>
      </thead>
      <tbody>
        @foreach($seasons as $season)
        <tr>
          <td id="status_background">1</td>
          <td>
            @if(!empty($serie->serie_image))
            <img alt="Imagem da série {{ $serie->serie_image }}" src="{{ URL::asset('static/images/uploads/' .$serie->serie_image) }}" />
            @else
            <img alt="Imagem da série {{ $serie->serie_image }}" src="{{ URL::asset('static/images/no_image.jpg') }}" />
            @endif
          </td>
          <td>{{ $serie->serie_name }} - {{ $season->season_number }}ª temporada</td>
          <td>{{ $season->season_score }}</td>
          <td id="td_episode_{{$season->id}}"><button id="episode_{{ $season->id }}" class="btn btn-link" onclick="addSelect({{ $season->id }})">0</button></td>
          <td>0/23</td>
          <td>
            <button class="btn btn-primary btn-sm">{!! file_get_contents('static/icons/edit.svg') !!}</button>
            <form method="POST" action="/series/{{ $serie->id }}/seasons/{{ $season->id }}">
              @csrf
              @method('DELETE')
              <button onclick="return confirm('Tem certeza que deseja excluir a {{ addslashes($serie->serie_name) }} - {{ $season->season_number }}ª temporada?')" class="btn btn-danger btn-sm">
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
    function addSelect(id, range = 30) {
        var x = document.createElement('SELECT');
        x.setAttribute("id", `select_${id}`);
        document.getElementById(`td_episode_${id}`).appendChild(x);
        document.getElementById(`episode_${id}`).classList.add('invisible');

        for (let i = 0; i <= range; i++) {
            var z = document.createElement("option");
            z.setAttribute("value", i);
            var t = document.createTextNode(i);
            z.appendChild(t);
            document.getElementById(`select_${id}`).appendChild(z);
        }
    }
</script>
@endsection