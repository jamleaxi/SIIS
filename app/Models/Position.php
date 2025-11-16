<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Position extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'position',
        'initial',
    ];

    public static function getOptions()
    {
        return self::all()->sortBy('position');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'position',
                'initial',
            ]) // log only these fields
            ->useLogName('position')         // set a custom log name
            ->logOnlyDirty()                 // log only changed values
            ->setDescriptionForEvent(fn(string $eventName) => "Position was {$eventName}");
    }
}
