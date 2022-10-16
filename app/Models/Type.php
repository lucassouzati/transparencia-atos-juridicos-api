<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Type extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'active',
    ];

    protected static function booted()
    {
            static::addGlobalScope('active', function (Builder $builder) {
                if (!auth('sanctum')->check())
                {
                    $builder->where('active', true);

                }
                else if (auth('sanctum')->user()->cannot('see_inactive_types'))
                {
                    $builder->where('active', true);
                }
            });
    }


    public function legalActs()
    {
        return $this->hasMany(LegalAct::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
