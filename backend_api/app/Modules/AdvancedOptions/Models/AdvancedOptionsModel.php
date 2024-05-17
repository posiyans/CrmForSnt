<?php

namespace App\Modules\AdvancedOptions\Models;

use App\Models\MyModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdvancedOptionsModel extends MyModel
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'type_value',
        'options'
    ];

    protected $casts = [
        'options' => 'array'
    ];
}
