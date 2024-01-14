<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Article extends Model
{
  use HasFactory;

  protected $fillable = [
    'id_user',
    'title',
    'content',
    'id_type',
    'id_tags',
    'bgArticle',
    'watched',
    'comment',
    'hidden',
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class, 'id_user', 'id');
  }
  public function comments(): HasMany
  {
    return $this->hasMany(Comment::class, 'id_post', 'id');
  }
  public function types()
  {
    return $this->belongsToMany(Type::class, 'types__articles', 'id_article', 'id_type');
  }
  public function MarkArticles(): BelongsTo
  {
    return $this->belongsTo(MarkupArticles::class, 'id', 'id_article');
  }
  public function WatchedArticles(): BelongsTo
  {
    return $this->belongsTo(WatchedArticles::class, 'id', 'id_article');
  }
  public function ReactionArticles(): hasMany
  {
    return $this->hasMany(Reaction::class, 'id_article', 'id');
  }
  public function reports(): hasMany
  {
    return $this->hasMany(ReportArticle::class, 'id_article', 'id');
  }
  public function scopeSearchArticles($query)
  {
    return $query->whereNull('hidden')->orderByDesc('watched')->orderByDesc('created_at')->paginate(10);
  }
}
