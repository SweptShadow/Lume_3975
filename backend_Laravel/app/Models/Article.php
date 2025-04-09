<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = "articles";

    protected $fillable = [
        "id",
        "title",
        "img",
        "description",
        "likes"
    ];

    public function likeds()
    {
        return $this->hasMany(Liked::class);
    }
}
