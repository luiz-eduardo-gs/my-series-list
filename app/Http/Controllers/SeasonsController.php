<?php

namespace App\Http\Controllers;

use App\Models\Season;
use App\Models\Serie;
use App\Models\WatchedEpisode;
use App\Services\CreateSeasons;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeasonsController extends Controller
{
    public function index(int $serieId)
    {
        $serie = Serie::find($serieId);
        $seasons = $serie->seasons;
        return view('seasons.index', compact('seasons', 'serie'));
    }

    public function create(Request $request)
    {
        $serieId = $request->serieId;
        return view('seasons.create', compact('serieId'));
    }

    public function store(Request $request, int $serieId, CreateSeasons $createSeasons)
    {
        $createSeasons->createSeason(
            $serieId,
            $request->seasons_qt
        );

        return redirect('/series' . '/' . $serieId . '/seasons');
    }

    public function destroy(int $serieId, int $seasonId)
    {
        DB::beginTransaction();
        $season = Season::find($seasonId);
        $season->destroy($seasonId);
        $serie = Serie::find($serieId);
        $serie->seasons_qt = $season->count();
        $serie->save();
        DB::commit();
        return redirect('/series' . '/' . $serieId . '/seasons')->with('success', "Temporada $season->season_number de $serie->serie_name deletada com sucesso.");
    }

    public function updateScore(Request $request, int $serieId, int $seasonId)
    {
        $newScore = $request->except('_token')["new_value"];
        $season = Season::find($seasonId);
        DB::beginTransaction();
        $season->season_score = $newScore;
        $season->save();
        DB::commit();
        return redirect('/series' . '/' . $serieId . '/seasons');
    }

    public function updateTotalEpisodes(Request $request, int $serieId, int $seasonId)
    {
        $newTotalEpisodes = $request->except('_token')["new_value"];
        $season = Season::find($seasonId);
        DB::beginTransaction();
        $season->watchedEpisodes->total_episodes_qt = (int) $newTotalEpisodes;
        $season->watchedEpisodes->save();
        $season->save();
        DB::commit();
        return redirect('/series' . '/' . $serieId . '/seasons');
    }

    public function updateWatchedEpisodesSelect(Request $request, int $serieId, int $seasonId)
    {
        $newWatchedEpisodes = $request->except('_token')["new_value"];
        $season = Season::find($seasonId);
        DB::beginTransaction();
        $season->watchedEpisodes->watched_episodes_qt = (int) $newWatchedEpisodes;
        $season->watchedEpisodes->save();
        $season->save();
        DB::commit();
        return redirect('/series' . '/' . $serieId . '/seasons');
    }

    public function checkAll(Request $request, int $serieId, int $seasonId)
    {
        DB::beginTransaction();
        $serie = Serie::find($serieId);
        $season = Season::find($seasonId);
        if($serie->seasons->count() == $season->season_number) {
            $serie->serie_status = 'C';
        }
        $seasonWatchedEpisodes = $season->watchedEpisodes;
        $seasonWatchedEpisodes->watched_episodes_qt = $seasonWatchedEpisodes->total_episodes_qt;
        $seasonWatchedEpisodes->save();
        $serie->save();
        DB::commit();
        return redirect('/series' . '/' . $serieId . '/seasons');
    }

    public function updateWatchedEpisodes(Request $request, int $serieId, int $seasonId)
    {
        DB::beginTransaction();
        $serie = Serie::find($serieId);
        $season = Season::find($seasonId);
        $watchedEpisodes = $season->watchedEpisodes;
        $episode = WatchedEpisode::find($watchedEpisodes->id);

        if(
            ($request->op == 'minus' and $episode->watched_episodes_qt == 0)
            or
            ($request->op == 'plus' and $episode->watched_episodes_qt == $episode->total_episodes_qt)
        ) {
            return redirect('/series' . '/' . $serieId . '/seasons');
        }
        if ($request->op == 'plus') {
            $episode->watched_episodes_qt +=  1;
            if(
                $episode->watched_episodes_qt == $episode->total_episodes_qt and
                $season->season_number == $serie->seasons->count()
            ) {
                $serie->serie_status = 'C';
            }
        }
        else if($request->op == 'minus'){
            $episode->watched_episodes_qt -=  1;
        }
        $episode->save();
        $season->save();
        $serie->save();
        DB::commit();
        return redirect('/series' . '/' . $serieId . '/seasons');
    }
}
