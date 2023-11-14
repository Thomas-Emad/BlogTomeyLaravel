<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;


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

}
