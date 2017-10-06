<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Company
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string $email
 * @property string $phone_number1
 * @property string $phone_number2
 * @property string $phone_number3
 * @property string $firm_number
 * @property string $tax_number
 * @property float $earnings_guarantee
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Client[] $clients
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Driver[] $drivers
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company whereEarningsGuarantee($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company whereFirmNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company wherePhoneNumber1($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company wherePhoneNumber2($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company wherePhoneNumber3($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company whereTaxNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property \Carbon\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Company withoutTrashed()
 * @property int $country_id
 * @property string|null $eu_tax_number
 * @property string|null $int_tax_number
 * @property int|null $commission
 * @property-read \App\Models\Country $country
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereCommission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereEuTaxNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereIntTaxNumber($value)
 * @property int $user_id
 * @property int $company_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Company whereUserId($value)
 */
class Company extends Model
{

    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'driver_companies';

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function drivers()
    {
        return $this->hasMany(Driver::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}