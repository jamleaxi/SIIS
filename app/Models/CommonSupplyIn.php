<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class CommonSupplyIn extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'cs_id',
        'qty_in',
        'price_in',
        'date_acquired',
        'reference',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'cs_id',
                'qty_in',
                'price_in',
                'date_acquired',
                'reference',
            ]) // log only these fields
            ->useLogName('supplies_in')         // set a custom log name
            ->logOnlyDirty()                 // log only changed values
            ->setDescriptionForEvent(fn(string $eventName) => "Supply (in) was {$eventName}");
    }
}
