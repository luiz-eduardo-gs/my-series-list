<?php

namespace App\Http\Controllers;

use App\Models\Serie;
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

    public function store(Request $request)
    {
        $request->validate([
            'serie_name' => 'required',
            'seasons_qt' => 'required'
        ]);
        $serie = new Serie();
        $serie->serie_name = $request->serie_name;
        $serie->serie_status = 'A';
        $serie->seasons_qt = $request->seasons_qt;

        $fileName = $serie->serie_name.".".$request->file('serie_image')->extension();
        $request->file('serie_image')->move(public_path('/static/images/uploads'), $fileName);
        $serie->serie_image = $fileName;
        $serie->save();
        return redirect('/series')->with('success', "Série $serie->name criada com sucesso.");
    }

    public function destroy(int $id)
    {
        DB::beginTransaction();
        $serie = Serie::find($id);
        $serie->destroy($id);
        DB::commit();
        return redirect('/series')->with('success', "Série $serie->name criada com sucesso.");
    }
}
