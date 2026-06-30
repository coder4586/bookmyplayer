<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class xx_email_spam extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'xx_email_spam';
    protected $guarded = [];
    public $timestamps = false;
}
