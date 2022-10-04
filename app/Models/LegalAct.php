<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class LegalAct extends Model
{
    use HasFactory, HasUuids;

    private $fillable = [
        'act_date',
        'title',
        'type',
        'description',
        'file',
    ];

}
