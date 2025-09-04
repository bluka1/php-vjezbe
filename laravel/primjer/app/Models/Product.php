<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  protected $fillable = ['name', 'color'];

  public function users() {
    return $this->belongsToMany(User::class);
  }
}
