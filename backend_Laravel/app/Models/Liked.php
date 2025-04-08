<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Liked extends Model
{
    protected $table = "likeds";

    protected $fillable = [
        "id",
        "article_id"
    ];


    public function article()
    {
        return $this->belongsTo(Article::class);
    }


}
