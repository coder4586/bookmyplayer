<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bmp_review_player extends Model
{
    use HasFactory;
    protected $table = 'bmp_review_players';
    protected $guarded = [];
    public $timestamps = false;
}
