<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Office extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'office',
        'initial',
    ];

    public static function getOptions()
    {
        return self::all()->sortBy('office');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'office',
                'initial',
            ]) // log only these fields
            ->useLogName('office')         // set a custom log name
            ->logOnlyDirty()                 // log only changed values
            ->setDescriptionForEvent(fn(string $eventName) => "Office was {$eventName}");
    }
}
