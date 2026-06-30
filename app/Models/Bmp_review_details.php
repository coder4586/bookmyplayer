<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bmp_review_details extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'bmp_review_details';
    protected $guarded = [];
    public $timestamps = false;
}
