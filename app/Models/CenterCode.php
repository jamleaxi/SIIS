<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class CenterCode extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'center',
        'code',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'center',
                'code',
            ]) // log only these fields
            ->useLogName('center_code')         // set a custom log name
            ->logOnlyDirty()                 // log only changed values
            ->setDescriptionForEvent(fn(string $eventName) => "Center Code was {$eventName}");
    }
}
