<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
  use HasFactory;
  protected $fillable = [
    'id_post',
    'id_user',
    'comment',
    'refer'
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class, 'id_user', 'id');
  }
  public function replies()
  {
    return $this->hasMany(Comment::class, 'refer')->with('replies');
  }
  public function article(): BelongsTo
  {
    return $this->belongsTo(Article::class, 'id_post', 'id');
  }
}
