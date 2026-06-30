<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bmp_leads_league extends Model
{
    use HasFactory;
    protected $connection = 'mysql'; // Specify the 'master' connection
    protected $table = 'bmp_leads_league';
    public $timestamps = false;
    protected $guarded = [];

}
