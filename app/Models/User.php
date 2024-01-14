<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable  implements MustVerifyEmail
{
  use HasApiTokens, HasFactory, Notifiable, HasRoles;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'email',
    'password',
    'type',
    'reports',
    'status',
    'img',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
  ];

  public function articles(): BelongsTo
  {
    return $this->belongsTo(Article::class, 'id', 'id_user')->select('articles.id', 'articles.id_user', 'title', 'bgArticle', 'content', 'watched', 'comment');
  }
  public function articles_saved(): BelongsToMany
  {
    return $this->belongsToMany(Article::class, 'markup_articles', 'id_user', 'id_article')->select('articles.id', 'title', 'bgArticle');
  }

  public function articles_watched(): BelongsToMany
  {
    return $this->belongsToMany(Article::class, 'watched_articles', 'id_user', 'id_article')->wherePivotNull('watched_articles.hidden')->withPivot('updated_at');
  }
  public function reports(): BelongsToMany
  {
    return $this->belongsToMany(Article::class, 'report_articles', 'id_article', 'id');
  }
  public function search(): HasMany
  {
    return $this->hasMany(SearchUser::class, 'id_user', 'id');
  }
  public function follow(): HasMany
  {
    return $this->hasMany(Followers::class, 'id_user', 'id');
  }
  public function followInfo(): HasMany
  {
    return $this->hasMany(User::class, 'id_user', 'id');
  }
  public function followers(): HasMany
  {
    return $this->hasMany(Followers::class, 'id_author', 'id');
  }
  public function articlesFol(): BelongsToMany
  {
    return $this->belongsToMany(Article::class, 'id_user', 'id_author');
  }
}
