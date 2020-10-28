<?php

namespace App\Services;
use App\Models\Serie;
use Illuminate\Support\Facades\DB;

class CreateSeries {

    public function createSerie($serieName, $seasonQt, $serieImage, $episodes, $status)
    {
        DB::beginTransaction();
        if ($status == 'C') {
            $serie = Serie::create([
                'serie_name' => $serieName,
                'serie_status' => 'C',
                'serie_image' => '',
                'seasons_qt' => $seasonQt
            ]);
            for($i = 1; $i <= $seasonQt; $i++) {
                $season = $serie->seasons()->create([
                    'season_number' => $i,
                    'season_score' => 0
                ]);
                $season->watchedEpisodes()->create([
                    'watched_episodes_qt' => $episodes,
                    'total_episodes_qt' => $episodes
                ]);
            }
        }
        else {
            $serie = Serie::create([
                'serie_name' => $serieName,
                'serie_status' => $status,
                'serie_image' => '',
                'seasons_qt' => $seasonQt
            ]);
        }

        if(!empty($serieImage)) {
            $fileName = $serieName.".".$serieImage->extension();
            $serieImage->move(public_path('/static/images/uploads'), $fileName);
            $serie->serie_image = $fileName;
        }else {
            $serie->serie_image = "";
        }

        $serie->save();

        if ($status <> "C") {
            for($i = 1; $i <= $seasonQt; $i++) {
                $season = $serie->seasons()->create([
                    'season_number' => $i,
                    'season_score' => 0
                ]);
                $season->watchedEpisodes()->create([
                    'total_episodes_qt' => $episodes
                ]);
            }
        }
        // Case I don't want to insert episodes when creating serie
        // if($episodes != null and $status <> "C") {
        //     for($i = 1; $i <= $seasonQt; $i++) {
        //         $season = $serie->seasons()->create([
        //             'season_number' => $i,
        //             'season_score' => 0
        //         ]);
        //         $season->watchedEpisodes()->create([
        //             'total_episodes_qt' => $episodes
        //         ]);
        //     }
        // }
        // else {
        //     for($i = 1; $i <= $seasonQt; $i++) {
        //         $season = $serie->seasons()->create([
        //             'season_number' => $i,
        //             'season_score' => 0
        //         ]);
        //     }
        // }
        DB::commit();
        return $serie;
    }
}