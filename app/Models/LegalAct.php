<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

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

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}
