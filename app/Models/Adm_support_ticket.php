<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adm_support_ticket extends Model
{
    use HasFactory;
    protected $connection = 'mysql_admin';
    protected $table = 'adm_support_ticket';
    public $timestamps = false;
    protected $guarded = [];
}
