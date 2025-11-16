<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SemiExpendable extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'code',
        'item',
        'description',
        'category',
        'fund',
        'unit',
        'date_acquired',
        'price',
        'est_life',
        'status',
        'custodian',
        'prev_cus',
        'date_transferred',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'code',
                'item',
                'description',
                'category',
                'fund',
                'unit',
                'date_acquired',
                'price',
                'est_life',
                'status',
                'custodian',
                'prev_cus',
                'date_transferred',
            ]) // log only these fields
            ->useLogName('semi_expendables')         // set a custom log name
            ->logOnlyDirty()                 // log only changed values
            ->setDescriptionForEvent(fn(string $eventName) => "Semi-Expendable was {$eventName}");
    }
}
