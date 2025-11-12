<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    use HasFactory;

    public $fillable = ['user_id', 'question', 'expires_at', 'slug'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($poll) {
            $poll->slug = \Illuminate\Support\Str::random(12);
        });
    }

    protected $appends = ['total_votes'];

    public function getTotalVotesAttribute()
    {
        return $this->options->sum(function ($option) {
            return $option->voters->count();
        });
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
