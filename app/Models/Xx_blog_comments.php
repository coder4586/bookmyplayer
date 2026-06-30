<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Xx_blog_comments extends Model
{
    use HasFactory;

    protected $table = 'xx_blog_comments'; 

    protected $fillable = [
        'site',
        'parent_id',
        'name',
        'comment',
        'blog_id',
        'status',
        'user_id',
        'creation_date',
        'update_date',
    ];

    public $timestamps = false; 
}
