<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Url extends Model
{
    use HasFactory;

    protected $fillable = ['original_url','short_code','user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function clicks(): HasMany
    {
        return $this->hasMany(Click::class);
    }

    protected static function booted(): void
    {
        static::creating(function ($model) {
            $model->short_code = self::generateUniqueCode();
            if(auth()->check()){
                $model->user_id = auth()->id();
            }
        });
    }

    public static function generateUniqueCode(): string
    {
        do {
            $code = Str::random(6);
        } while (self::where('short_code', $code)->exists());

        return $code;
    }
}
