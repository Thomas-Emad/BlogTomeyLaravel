<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasMany;

class Type extends Model
{
  use HasFactory;
  protected $fillable = [
    'name'
  ];

  public function typeArticles(): hasMany
  {
    return $this->hasMany(Types_Articles::class, 'id_type', 'id');
  }
}
