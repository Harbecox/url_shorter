<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Click extends Model
{
    use HasFactory;

    protected $fillable = ['url_id', 'ip_address','created_at'];

    public function url(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Url::class);
    }
}
