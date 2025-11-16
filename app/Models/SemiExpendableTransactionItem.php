<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SemiExpendableTransactionItem extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'transaction_id',
        'itemnum',
        'sep_id',
        'sep_code',
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
                'sep_id',
                'sep_code',
                'quantity',
                'price',
                'total',
            ]) // log only these fields
            ->useLogName('semi_expendables_transaction_items')         // set a custom log name
            ->logOnlyDirty()                 // log only changed values
            ->setDescriptionForEvent(fn(string $eventName) => "Semi-Expendable request (items) was {$eventName}");
    }
}
