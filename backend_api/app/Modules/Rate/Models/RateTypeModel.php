<?php

namespace App\Modules\Rate\Models;

use App\Models\MyModel;

/**
 * Модель едииницы тарифа (день, ночь, мусор, Целевой взнос, Членский взнос)
 **/
class RateTypeModel extends MyModel
{
    protected $casts = [
        'enable' => 'boolean',
    ];

    protected $current_date = null;

    /**
     * @param null $current_date
     */
    public function setCurrentDate($current_date): void
    {
        $this->current_date = $current_date;
    }

    /**
     * @return null
     */
    public function getCurrentDate()
    {
        if ($this->current_date) {
            return $this->current_date;
        } else {
            return date('Y-m-d');
        }
    }

    protected $fillable = ['name', 'description'];

    public function rate_group()
    {
        return $this->belongsTo(RateGroupModel::class, 'rate_group_id', 'id');
    }

    /**
     * получить тариф на current_date
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function currentRate()
    {
        $data = $this->getCurrentDate();
        return $this->hasOne(RateModel::class, 'rate_type_id', 'id')
            ->where('date_start', '<', $data)
            ->orderBy('date_start', 'desc')
            ->orderBy('id', 'desc');
    }


}
