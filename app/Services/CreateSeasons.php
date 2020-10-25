<?php

namespace App\Services;

use App\Models\Season;
use App\Models\Serie;
use Illuminate\Support\Facades\DB;

class CreateSeasons {

    public function createSeason($serieId, $seasonQt)
    {
        DB::beginTransaction();
        $total = Serie::find($serieId)->seasons->count();
        $episodes = Serie::find($serieId)->seasons
            ->first()
            ->watchedEpisodes
            ->total_episodes_qt;
        for($i=$total+1; $i <= $total + $seasonQt; $i++){
            $season = Season::create([
                'serie_id' => $serieId,
                'season_number' =>  $i,
                'season_score' => 0
            ]);
            $season->watchedEpisodes()->create([
                'total_episodes_qt' => $episodes
            ]);
        }
        DB::commit();
    }
}