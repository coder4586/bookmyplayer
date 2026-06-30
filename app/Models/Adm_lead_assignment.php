<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adm_lead_assignment extends Model
{
    use HasFactory;
    protected $connection = 'mysql_admin';
    protected $table = 'adm_lead_assignment';
    public $timestamps = false;
    protected $guarded = [];
}
