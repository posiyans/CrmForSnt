<?php

namespace App\Modules\AdvancedOptions\Models;

use App\Models\MyModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdvancedOptionsValueModel extends MyModel
{
    use HasFactory;

    protected $fillable = [
        'advanced_options_id',
        'commentable_id'
    ];

    protected $casts = [
        'value' => 'array'
    ];


    public function advanced_options()
    {
        return $this->hasOne(AdvancedOptionsModel::class, 'id', 'advanced_options_id');
    }
}

