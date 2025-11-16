<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SemiExpendableTransaction extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'tcode',
        'icsnum',
        'fund',
        'office',
        'purpose',
        'custodian_id',
        'custodian',
        'position_cus',
        'date_cus',
        'sign_cus',
        'issuer_id',
        'issuer',
        'position_iss',
        'date_iss',
        'sign_iss',
        'ics_generation',
        'overall_total',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'tcode',
                'icsnum',
                'fund',
                'office',
                'purpose',
                'custodian_id',
                'custodian',
                'position_cus',
                'date_cus',
                'sign_cus',
                'issuer_id',
                'issuer',
                'position_iss',
                'date_iss',
                'sign_iss',
                'ics_generation',
                'overall_total',
            ]) // log only these fields
            ->useLogName('semi_expendables_transaction')         // set a custom log name
            ->logOnlyDirty()                 // log only changed values
            ->setDescriptionForEvent(fn(string $eventName) => "Semi-Expendable request was {$eventName}");
    }
}
