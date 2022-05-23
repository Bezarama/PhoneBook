<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'phone',
        'is_favourite',
    ];

    protected $casts = [
        'is_favourite' => 'boolean',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Скоуп для выбора только избранных контактов
     * @param $query
     * @return mixed
     */
    public function scopeFavouritesOnly($query)
    {
        return $query->where('is_favourite', true);
    }

    /**
     * Скоуп для выбора только НЕ избранных контактов
     * @param $query
     * @return mixed
     */
    public function scopeNonFavouritesOnly($query)
    {
        return $query->where('is_favourite', false);
    }

}
