<?php

namespace App\Modules\Billing\Models;

use App\Models\MyModel;
use App\Models\Stead;
use App\Modules\Rate\Models\RateGroupModel;
use App\Modules\Stead\Models\SteadModel;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Modules\Billing\Models\BillingInvoice
 *
 * @property int $id
 * @property string $title
 * @property int $stead_id
 * @property int $type
 * @property int|null $reestr_id
 * @property float $price
 * @property int|null $payment_id
 * @property bool $paid оплачен счет?
 * @property int|null $user_id
 * @property string|null $description подробное описание
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modules\Receipt\Models\ReceiptTypeModels|null $ReceiptTypeModels
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Modules\File\Models\FileModel> $files
 * @property-read int|null $files_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Log> $log
 * @property-read int|null $log_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Message\MessageModel> $message
 * @property-read int|null $message_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Modules\MeteringDevice\Models\InstrumentReadingModel> $metersData
 * @property-read int|null $meters_data_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Modules\Billing\Models\BillingPaymentModel> $payments
 * @property-read int|null $payments_count
 * @property-read Stead|null $stead
 * @method static \Illuminate\Database\Eloquent\Builder|BillingInvoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BillingInvoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BillingInvoice onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|BillingInvoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|BillingInvoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingInvoice whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingInvoice whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingInvoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingInvoice wherePaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingInvoice wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingInvoice wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingInvoice whereReestrId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingInvoice whereSteadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingInvoice whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingInvoice whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingInvoice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingInvoice whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingInvoice withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|BillingInvoice withoutTrashed()
 * @mixin \Eloquent
 */
class BillingInvoiceModel extends MyModel
{

    use SoftDeletes;

    protected $fillable = ['title'];

    protected $casts = [
        'is_paid' => 'boolean',
        'price' => 'decimal:2',
        'options' => 'array',
    ];

    public function commentable()
    {
        return $this->morphTo();
    }


    /**
     * участок счета
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
     * группа тарифов
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function rate_group()
    {
        return $this->hasOne(RateGroupModel::class, 'id', 'rate_group_id');
    }

    public function payments()
    {
        return $this->hasMany(BillingPaymentModel::class, 'invoice_id', 'id');
    }


}
