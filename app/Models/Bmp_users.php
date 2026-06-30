<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bmp_users extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'bmp_user';
    protected $guarded = [];
    public $timestamps = false;
}
