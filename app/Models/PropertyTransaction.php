<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class PropertyTransaction extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'tcode',
        'parnum',
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
        'par_generation',
        'overall_total',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'tcode',
                'parnum',
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
                'par_generation',
                'overall_total',
            ]) // log only these fields
            ->useLogName('properties_transaction')         // set a custom log name
            ->logOnlyDirty()                 // log only changed values
            ->setDescriptionForEvent(fn(string $eventName) => "Property request was {$eventName}");
    }
}
