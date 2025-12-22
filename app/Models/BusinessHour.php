<?php

namespace App\Models;

use App\Models\Vcard;
use Illuminate\Support\Carbon;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\BusinessHour
 *
 * @property int $id
 * @property int $vcard_id
 * @property int $day_of_week
 * @property string $start_time
 * @property string $end_time
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|BusinessHour newModelQuery()
 * @method static Builder|BusinessHour newQuery()
 * @method static Builder|BusinessHour query()
 * @method static Builder|BusinessHour whereCreatedAt($value)
 * @method static Builder|BusinessHour whereDayOfWeek($value)
 * @method static Builder|BusinessHour whereEndTime($value)
 * @method static Builder|BusinessHour whereId($value)
 * @method static Builder|BusinessHour whereStartTime($value)
 * @method static Builder|BusinessHour whereUpdatedAt($value)
 * @method static Builder|BusinessHour whereVcardId($value)
 *
 * @mixin Eloquent
 */
class BusinessHour extends Model
{
    use HasFactory;

    protected $table = 'business_hours';

    /**
     * @var array
     */
    protected $fillable = [
        'vcard_id',
        'whatsapp_store_id',
        'day_of_week',
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'vcard_id' => 'integer',
        'whatsapp_store_id' => 'integer',
        'day_of_week' => 'integer',
        'start_time' => 'string',
        'end_time' => 'string',
    ];

    const MON = 1;

    const TUE = 2;

    const WED = 3;

    const THU = 4;

    const FRI = 5;

    const SAT = 6;

    const SUN = 7;

    const DAY_OF_WEEK = [
        self::MON => 'mon',
        self::TUE => 'tue',
        self::WED => 'wed',
        self::THU => 'thu',
        self::FRI => 'fri',
        self::SAT => 'sat',
        self::SUN => 'sun',
    ];

    const WEEKDAY_NAME = [
        self::MON => 'MON',
        self::TUE => 'TUE',
        self::WED => 'WED',
        self::THU => 'THU',
        self::FRI => 'FRI',
        self::SAT => 'SAT',
        self::SUN => 'SUN',
    ];

    const MON_TO_SUN = 1;

    const SUN_TO_SAT = 2;

    const WEEK_FORMAT_TYPE = [
        self::MON_TO_SUN => 'mon_to_sun',
        self::SUN_TO_SAT => 'sun_to_sat',
    ];

    public function vcard(): BelongsTo
    {
        return $this->belongsTo(Vcard::class, 'vcard_id');
    }

    public function whatsappStore(): BelongsTo
    {
        return $this->belongsTo(WhatsappStore::class, 'whatsapp_store_id');
    }
}
