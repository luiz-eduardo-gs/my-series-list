<?php

namespace App\Services;
use App\Models\Serie;
use Illuminate\Support\Facades\DB;

class CreateSeries {

    public function createSerie($serieName, $seasonQt, $serieImage)
    {
        DB::beginTransaction();
        $serie = Serie::create([
            'serie_name' => $serieName,
            'serie_status' => 'A',
            'serie_image' => '',
            'seasons_qt' => $seasonQt
        ]);

        if(!empty($serieImage)) {
            $fileName = $serieName.".".$serieImage->extension();
            $serieImage->move(public_path('/static/images/uploads'), $fileName);
            $serie->serie_image = $fileName;
        }else {
            $serie->serie_image = "";
        }

        $serie->save();

        for($i = 1; $i <= $seasonQt; $i++) {
            $serie->seasons()->create([
                'season_number' => $i,
                'season_score' => 0
            ]);
        }
        DB::commit();
        return $serie;
    }
}