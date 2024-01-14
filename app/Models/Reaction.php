<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
  use HasFactory;

  protected $fillable = [
    'id_user',
    'id_article',
    'action'
  ];
  public function article()
  {
    return $this->belongsTo(Article::class,  'article_id');
  }
}
