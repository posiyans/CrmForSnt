<?php

namespace App\Modules\Billing\Models;

use App\Models\MyModel;
use App\Modules\MeteringDevice\Models\InstrumentReadingModel;
use App\Modules\Rate\Models\RateGroupModel;
use App\Modules\Stead\Models\SteadModel;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * App\Modules\Billing\Models\BillingPaymentModel
 *
 * @property int $id
 * @property int|null $stead_id id участка
 * @property string|null $description
 * @property int|null $type тип платежа
 * @property float $price
 * @property string|null $transaction
 * @property string $payment_date
 * @property int|null $reestr_id
 * @property int $payment_type
 * @property array $raw_data
 * @property int|null $invoice_id
 * @property int|null $user_id
 * @property bool $error есть ли неточности в строке
 * @property array $history
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Modules\File\Models\FileModel> $files
 * @property-read int|null $files_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Modules\MeteringDevice\Models\InstrumentReadingModel> $instrumentReadings
 * @property-read int|null $instrument_readings_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Log> $log
 * @property-read int|null $log_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Message\MessageModel> $message
 * @property-read int|null $message_count
 * @property-read Stead|null $stead
 * @method static \Illuminate\Database\Eloquent\Builder|BillingPaymentModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BillingPaymentModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BillingPaymentModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|BillingPaymentModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingPaymentModel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingPaymentModel whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingPaymentModel whereError($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingPaymentModel whereHistory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingPaymentModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingPaymentModel whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingPaymentModel wherePaymentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingPaymentModel wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingPaymentModel wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingPaymentModel whereRawData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingPaymentModel whereReestrId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingPaymentModel whereSteadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingPaymentModel whereTransaction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingPaymentModel whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingPaymentModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingPaymentModel whereUserId($value)
 * @mixin \Eloquent
 */
class BillingPaymentModel extends MyModel
{
    use SoftDeletes;

    //
    protected $casts = [
        "id" => 'integer',
        'stead_id' => 'integer',
        'rate_group_id' => 'integer',
        'invoice_id' => 'integer',
        'payment_type' => 'integer',
        'user_id' => 'integer',
        'raw_data' => 'array',
        'price' => 'decimal:2',
        'error' => 'boolean'
    ];

    protected $fillable = ['type', 'description'];

    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * участок который платил
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function stead()
    {
        if ($this->commentable_type == SteadModel::class) {
            return $this->hasOne(SteadModel::class, 'id', 'commentable_id');
        }
        return null;
    }

    /**
     * для совместимости
     *
     * @param $value
     * @return void
     */
    public function setSteadIdAttribute($value)
    {
        $this->commentable_type = SteadModel::class;
        $this->commentable_id = $value;
    }

    /**
     * для совместимости
     *
     * @param $value
     * @return void
     */
    public function getSteadIdAttribute($value)
    {
        if ($this->commentable_type == SteadModel::class) {
            return $this->commentable_id;
        }
        return null;
    }


    /**
     * группа тарифов к которой относится платеж
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function rate_group()
    {
        return $this->hasOne(RateGroupModel::class, 'id', 'rate_group_id');
    }

    /**
     * участок который платил
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function invoice()
    {
        return $this->hasOne(BillingInvoiceModel::class, 'id', 'invoice_id');
    }

    /**
     * показания приборов за который заплатили
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function instrument_readings()
    {
        return $this->hasMany(InstrumentReadingModel::class, 'payment_id', 'id');
    }


}
