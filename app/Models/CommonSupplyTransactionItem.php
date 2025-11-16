<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class CommonSupplyTransactionItem extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'transaction_id',
        'itemnum',
        'cs_id',
        'cs_code',
        'quantity_req',
        'available',
        'quantity_iss',
        'price',
        'total',
        'remarks',
        'disbursed',
        'fund',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'transaction_id',
                'itemnum',
                'cs_id',
                'cs_code',
                'quantity_req',
                'available',
                'quantity_iss',
                'price',
                'total',
                'remarks',
                'disbursed',
                'fund',
            ]) // log only these fields
            ->useLogName('supplies_transaction_items')         // set a custom log name
            ->logOnlyDirty()                 // log only changed values
            ->setDescriptionForEvent(fn(string $eventName) => "Supply request (items) was {$eventName}");
    }
}
