<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class CommonSupplyOut extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'cs_id',
        'qty_out',
        'price_out',
        'transaction_id',
        'date_released',
        'reference_out',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'cs_id',
                'qty_out',
                'price_out',
                'transaction_id',
                'date_released',
                'reference_out',
            ]) // log only these fields
            ->useLogName('supplies_out')         // set a custom log name
            ->logOnlyDirty()                 // log only changed values
            ->setDescriptionForEvent(fn(string $eventName) => "Supply (out) was {$eventName}");
    }
}
