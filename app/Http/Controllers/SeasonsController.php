<?php

namespace App\Http\Controllers;

use App\Models\Season;
use App\Models\Serie;
use Exception;
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

    public function destroy(int $serieId, int $seasonId)
    {
        DB::beginTransaction();
        $season = Season::find($seasonId);
        $season->destroy($seasonId);
        $serie = Serie::find($serieId);
        $serie->seasons_qt = $season->count();
        $serie->save();
        DB::commit();
        return redirect('/series')->with('success', "Série $season->season_number deletada com sucesso.");
    }
}
