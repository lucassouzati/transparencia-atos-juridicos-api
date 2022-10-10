<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Type extends Model
{
    use HasFactory;

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
            });
    }


    public function legalActs()
    {
        return $this->hasMany(LegalAct::class);
    }
}
