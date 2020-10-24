<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    use HasFactory;
    protected $fillable = ['serie_name', 'seasons_qt', 'serie_image', 'serie_status'];

    public function seasons()
    {
        return $this->hasMany(Season::class);
    }
}
