<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Types_Articles extends Model
{
  use HasFactory;
  protected $fillable = [
    'id_article',
    'id_type',
  ];

  public function type(): BelongsTo
  {
    return $this->BelongsTo(Type::class, 'id_type', 'id');
  }
}
