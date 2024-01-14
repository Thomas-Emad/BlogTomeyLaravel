<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportArticle extends Model
{
  use HasFactory;
  protected $fillable = [
    'id_user_report',
    'id_article'
  ];
}
