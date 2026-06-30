<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bmp_subscriptions extends Model
{
    use HasFactory;

    protected $table = 'bmp_subscription';

    protected $fillable = [
        'email',
        'ip',
        'browser',
        'ref_url',
    ];

    protected $primaryKey = 'id'; 
    public $timestamps = false; 
}

