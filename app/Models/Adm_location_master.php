<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adm_location_master extends Model
{
    use HasFactory;
    protected $table = 'adm_location_master';
    protected $guarded = [];
    public $timestamps = false;
}
