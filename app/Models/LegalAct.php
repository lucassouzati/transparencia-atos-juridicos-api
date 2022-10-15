<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class LegalAct extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

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
                    else if (auth('sanctum')->user()->cannot('see_published_legalacts'))
                    {
                        $builder->where('published', true);
                    }
            });
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    protected function file(): Attribute
    {
        return Attribute::make(
            set: fn($value) => $value->getClientOriginalName()
        );
    }

}
