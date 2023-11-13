<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article_Tags extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_article',
        'id_tag'
    ];
}
