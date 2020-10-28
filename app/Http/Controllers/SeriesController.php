<?php

namespace App\Http\Controllers;

use App\Models\Season;
use App\Models\Serie;
use App\Services\CreateSeries;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeriesController extends Controller
{
    public function index()
    {
        $seriesAll = Serie::all();
        $url = $_SERVER['REQUEST_URI'];
        $url_components = parse_url($url);
        $series = array();
        try {
            parse_str($url_components['query'], $params);
            foreach($seriesAll as $serie){
                if ($serie->serie_status == $params["status"])
                    array_push($series, $serie);
                    
            }
        }
        catch(Exception $e){
            $series = $seriesAll;
        }
        return view('series.index', compact('series'));
    }

    public function create()
    {
        return view('series.create');
    }

    public function update(Request $request, int $serieId)
    {
        $serie = Serie::find($serieId);
        $serie->serie_name = $request->new_serie_name;
        $serie->save();
    }

    public function updateStatus(Request $request, int $serieId)
    {
        $serie = Serie::find($serieId);
        if ($request->new_value == 'C') {
            $serie->seasons->each(function (Season $season) {
                $season->watchedEpisodes->watched_episodes_qt = $season->watchedEpisodes->total_episodes_qt;
            });
            $serie->push();
        }
        $serie->serie_status = $request->new_value;
        $serie->save();   
        return redirect('/series')->with('success', "Status alterado com sucesso.");
    }

    public function store(Request $request, CreateSeries $createSeries)
    {
        $request->validate([
            'serie_name' => 'required',
            'seasons_qt' => 'required',
            'total_episodes_qt' => 'required'
        ]);

        $serie = $createSeries->createSerie(
            $request->serie_name,
            $request->seasons_qt,
            $request->file('serie_image'),
            $request->total_episodes_qt,
            $request->serie_status
        );

        return redirect('/series')->with('success', "Série $serie->name criada com sucesso.");
    }

    public function destroy(int $serieId)
    {
        DB::beginTransaction();
        $serie = Serie::find($serieId);
        $imagePath = public_path('/static/images/uploads') . '/' . $serie->serie_image;
        try {
            unlink($imagePath);
        }
        catch(Exception $e) {}
        finally {
            $serie->destroy($serieId);
            DB::commit();
            return redirect('/series')->with('success', "Série $serie->serie_name deletada com sucesso.");
        }
    }
}
