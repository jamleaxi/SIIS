<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class PropertyTransactionItem extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'transaction_id',
        'itemnum',
        'ppe_id',
        'ppe_code',
        'quantity',
        'price',
        'total',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'transaction_id',
                'itemnum',
                'ppe_id',
                'ppe_code',
                'quantity',
                'price',
                'total',
            ]) // log only these fields
            ->useLogName('properties_transaction_item')         // set a custom log name
            ->logOnlyDirty()                 // log only changed values
            ->setDescriptionForEvent(fn(string $eventName) => "Property request (items) was {$eventName}");
    }
}
