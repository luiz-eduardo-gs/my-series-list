<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function watchedEpisodes()
    {
        $this->hasOne(WatchedEpisode::class);
    }
}
