<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class WatchedArticles extends Model
{
  use HasFactory;
  protected $fillable = [
    'id_user',
    'id_article',
    'updated_at'
  ];

  public function user(): HasOne
  {
    return $this->hasOne(User::class, 'id', 'id_user');
  }
}
