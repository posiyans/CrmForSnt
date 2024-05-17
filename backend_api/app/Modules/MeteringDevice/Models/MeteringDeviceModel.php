<?php

namespace App\Modules\MeteringDevice\Models;


use App\Models\MyModel;
use App\Modules\Rate\Models\RateTypeModel;
use App\Modules\Stead\Models\SteadModel;

/*
 * Модель приборов учета
 */

/**
 * App\Models\MeteringDevice\Models\MeteringDevice
 *
 * @property int $id
 * @property string $type_id
 * @property string|null $name
 * @property string|null $description
 * @property bool|null $enable
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\File\Models\FileModel> $files
 * @property-read int|null $files_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Log> $log
 * @property-read int|null $log_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Message\MessageModel> $message
 * @property-read int|null $message_count
 * @property-read \App\Models\Receipt\Models\ReceiptTypeModels|null $receiptType
 * @method static \Illuminate\Database\Eloquent\Builder|MeteringDevice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MeteringDevice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MeteringDevice query()
 * @method static \Illuminate\Database\Eloquent\Builder|MeteringDevice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MeteringDevice whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MeteringDevice whereEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MeteringDevice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MeteringDevice whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MeteringDevice whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MeteringDevice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MeteringDeviceModel extends MyModel
{

    protected $casts = [
        'id' => 'integer',
        'options' => 'array',
    ];

    protected $fillable = [
        'initial_data',
        'description',
        'active'
    ];

    protected $options_fillable = [
        'device_brand',
        'serial_number',
        'installation_date',
        'verification_date',
    ];

    /**
     * jот какого участка прибор
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     *
     */
    public function stead()
    {
        return $this->hasOne(SteadModel::class, 'id', 'stead_id');
    }

    /**
     * по какому тарифу тарифицируется прибор
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function rate_type()
    {
        return $this->hasOne(RateTypeModel::class, 'id', 'rate_type_id');
    }


    /**
     * по какой группе тарифов относится  прибор
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function rate_group()
    {
        return $this->rate_type->rate_group();
    }


    /**
     * показания прибора
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function instrument_readings()
    {
        return $this->hasMany(InstrumentReadingModel::class, 'metering_device_id', 'id');
    }

    /**
     * последнее показание пробора
     *
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\HasMany|object|null
     */
    public function last_reading()
    {
        return $this->instrument_readings()->orderByDesc('date')->orderByDesc('created_at')->first();
    }


}
