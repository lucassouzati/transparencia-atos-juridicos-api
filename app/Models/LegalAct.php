<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LegalAct extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'act_date',
        'title',
        'type_id',
        'description',
        'file',
        'published'
    ];

    protected static function booted()
    {
            static::addGlobalScope('published', function (Builder $builder) {
                    if (!auth('sanctum')->check())
                    {
                        $builder->where('published', true);

                    }
                    else if (!auth('sanctum')->user()->can('see_published_legalacts'))
                    {
                        $builder->where('published', true);
                    }
            });
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

}
