<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentMeta extends Model
{
    protected $table = "content_meta";

    public function contents()
    {
        return $this->belongsTo(Content::class);
    }
}
