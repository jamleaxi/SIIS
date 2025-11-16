<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class CommonSupply extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'code',
        'item',
        'description',
        'category',
        'fund',
        'remarks',
        'low_indicator',
        'unit',
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
                'remarks',
                'low_indicator',
                'unit',
            ]) // log only these fields
            ->useLogName('supplies')         // set a custom log name
            ->logOnlyDirty()                 // log only changed values
            ->setDescriptionForEvent(fn(string $eventName) => "Supply was {$eventName}");
    }
}
