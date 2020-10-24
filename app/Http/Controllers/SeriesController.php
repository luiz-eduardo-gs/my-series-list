<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use App\Services\CreateSeries;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeriesController extends Controller
{
    public function index()
    {
        $series = Serie::all();
        return view('series.index', compact('series'));
    }

    public function create()
    {
        return view('series.create');
    }

    public function store(Request $request, CreateSeries $createSeries)
    {
        $request->validate([
            'serie_name' => 'required',
            'seasons_qt' => 'required'
        ]);

        $serie = $createSeries->createSerie(
            $request->serie_name,
            $request->seasons_qt,
            $request->file('serie_image')
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
