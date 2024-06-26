<?php

namespace App\Modules\Owner\Models;

use App\Models\MyModel;
use App\Modules\Stead\Models\SteadModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * отношения участка и собственника
 *
 * App\Models\Owner\OwnerUserSteadModel
 *
 * @property int $id
 * @property string $owner_uid uid собственника
 * @property int $stead_id id участка
 * @property int $proportion Доля собственности
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Modules\File\Models\FileModel> $files
 * @property-read int|null $files_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Log> $log
 * @property-read int|null $log_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Message\MessageModel> $message
 * @property-read int|null $message_count
 * @property-read \App\Models\Owner\OwnerUserModel|null $owner
 * @property-read Stead|null $stead
 * @method static \Illuminate\Database\Eloquent\Builder|OwnerUserSteadModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OwnerUserSteadModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OwnerUserSteadModel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|OwnerUserSteadModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|OwnerUserSteadModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OwnerUserSteadModel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OwnerUserSteadModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OwnerUserSteadModel whereOwnerUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OwnerUserSteadModel whereProportion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OwnerUserSteadModel whereSteadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OwnerUserSteadModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OwnerUserSteadModel withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|OwnerUserSteadModel withoutTrashed()
 * @mixin \Eloquent
 */
class OwnerUserSteadModel extends MyModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['stead_id', 'owner_uid'];
    protected $table = 'owner_user_model_stead_model';

    protected $casts = [
        'proportion' => 'integer'
    ];

    public function owner()
    {
        return $this->hasOne(OwnerUserModel::class, 'uid', 'owner_uid');
    }

    public function stead()
    {
        return $this->hasOne(SteadModel::class, 'id', 'stead_id');
    }


}
