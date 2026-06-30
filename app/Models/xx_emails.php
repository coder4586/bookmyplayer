<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class xx_emails extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'xx_emails';
    protected $guarded = [];
    public $timestamps = false;
}
