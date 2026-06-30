<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bmp_leads extends Model
{
    use HasFactory;
    protected $connection = 'mysql'; // Specify the 'master' connection
    protected $table = 'bmp_leads';
    public $timestamps = false;
    protected $guarded = [];

}
