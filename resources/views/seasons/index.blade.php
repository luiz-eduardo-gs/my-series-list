@extends('main_layout')

@section('title')
Temporadas de {{$serie->serie_name}}
@endsection

@section('css')
<link rel="stylesheet" href="{{ URL::asset('static/css/bootstrap.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('static/css/index.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('static/css/index_seasons.css') }}" />
@endsection

@section('main')
<a href="/series/{{$serie->id}}/seasons/create" class="btn btn-primary btn-lg" id="add_season">+</a>
<section class="box">
  <div id="list_header">
    <h4 style="margin-top: 0;" class="box">TEMPORADAS DE {{strtoupper($serie->serie_name)}}</h4>
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Imagem</th>
          <th>Nome da temporada</th>
          <th>Nota</th>
          <th>Progresso</th>
          <th>Opções</th>
        </tr>
      </thead>
      <tbody>
        <?php $count = 0; ?>
        @foreach($seasons as $season)
        <tr>
          <td id="status_background"><?php echo ++$count ?></td>
          <td>
            @if(!empty($serie->serie_image))
            <img alt="Imagem da série {{ $serie->serie_image }}" src="{{ URL::asset('static/images/uploads/' .$serie->serie_image) }}" />
            @else
            <img alt="Imagem da série {{ $serie->serie_image }}" src="{{ URL::asset('static/images/no_image.jpg') }}" />
            @endif
          </td>
          <td>{{ $serie->serie_name }} - {{ $season->season_number }}ª temporada</td>
          <td id="td_score_{{$season->id}}">
            <form id="form_score_{{$season->id}}" method="POST" action="/series/{{$serie->id}}/seasons/{{ $season->id }}/updateScore">
              @csrf
              <span>{{ $season->season_score }}</span>
              <a hidden onclick="addSelect({{$season->id}}, {{$season->season_score}}, 10, 'form_score')">
                {{ $season->season_score }}
              </a>
            </form>
          </td>
          <td id="td_episodes_{{$season->id}}">
            <form method="POST" action="/series/{{ $serie->id }}/seasons/{{ $season->id }}">
              @csrf
              <input name="op" value="minus" hidden>
              <button>
                {!! file_get_contents('static/icons/minus_circle.svg') !!}
              </button>
            </form>
            <form id="form_watched_episodes_{{$season->id}}" method="POST" action="/series/{{ $serie->id }}/seasons/{{ $season->id }}/updateWatchedEpisodesSelect">
              @csrf
              <span>{{ $season->watchedEpisodes->watched_episodes_qt }}</span>
              <a hidden onclick="addSelect({{$season->id}}, {{ $season->watchedEpisodes->watched_episodes_qt }}, {{ $season->watchedEpisodes->total_episodes_qt }}, 'form_watched_episodes')">
                {{ $season->watchedEpisodes->watched_episodes_qt }}
              </a>
            </form>
            /
            <form id="form_total_episodes_{{$season->id}}" method="POST" action="/series/{{ $serie->id }}/seasons/{{ $season->id }}/updateTotalEpisodes">
              @csrf
              <span>{{ $season->watchedEpisodes->total_episodes_qt }}</span>
              <a hidden onclick="addSelect({{$season->id}}, {{ $season->watchedEpisodes->total_episodes_qt }}, 50, 'form_total_episodes')">
                {{ $season->watchedEpisodes->total_episodes_qt }}
              </a>
            </form>
            <form method="POST" action="/series/{{ $serie->id }}/seasons/{{ $season->id }}">
              @csrf
              <input name="op" value="plus" hidden>
              <button>
                {!! file_get_contents('static/icons/plus_circle.svg') !!}
              </button>
            </form>
          </td>
          <td>
            <form method="POST" action="/series/{{$serie->id}}/seasons/{{$season->id}}/checkAll">
              @csrf
              <button onclick="return confirm('Tem certeza que deseja marcar todos os episódios dessa temporada como Assistidos?')" style="color: black;" class="btn btn-info btn-sm">
                {!! file_get_contents('static/icons/check_all.svg') !!}
              </button>
            </form>
            <button onclick="toggleEdit({{$season->id}})" class="btn btn-primary btn-sm">{!! file_get_contents('static/icons/edit.svg') !!}</button>
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
  function addSelect(id, current, range = 30, formId) {
    var x = document.createElement('SELECT');
    x.setAttribute("id", `select_${formId}_${id}`);
    x.setAttribute("name", `new_value`);
    x.setAttribute("onchange", `submitForm('${formId}_${id}')`);
    document.getElementById(`${formId}_${id}`).appendChild(x);
    document.querySelector(`#${formId}_${id} > a`).hidden = true;
    for (let i = 0; i <= range; i++) {
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

  function sendForm(serieId, seasonId, operation) {
    let formData = new FormData();
    const token = document.querySelector('input[name="_token"]').value;
    formData.append('_token', token);
    formData.append('operation', operation);
    const url = `/series/${serieId}/seasons/${seasonId}`;
    fetch(url, {
      body: formData,
      method: 'POST'
    });
  }

  function toggleEdit(seasonId) {
    if (document.querySelector(`#td_score_${seasonId} > form > a`).hidden == true) {
      document.querySelector(`#td_score_${seasonId} > form > a`).hidden = false;
      document.querySelector(`#td_score_${seasonId} > form > span`).hidden = true;
      document.querySelector(`#form_watched_episodes_${seasonId} > a`).hidden = false;
      document.querySelector(`#form_watched_episodes_${seasonId} > span`).hidden = true;
      document.querySelector(`#form_total_episodes_${seasonId} > a`).hidden = false;
      document.querySelector(`#form_total_episodes_${seasonId} > span`).hidden = true;
    } else {
      document.querySelector(`#td_score_${seasonId} > form > a`).hidden = true;
      document.querySelector(`#td_score_${seasonId} > form > span`).hidden = false;
      document.querySelector(`#form_watched_episodes_${seasonId} > a`).hidden = true;
      document.querySelector(`#form_watched_episodes_${seasonId} > span`).hidden = false;
      document.querySelector(`#form_total_episodes_${seasonId} > a`).hidden = true;
      document.querySelector(`#form_total_episodes_${seasonId} > span`).hidden = false;
    }
  }
</script>
@endsection