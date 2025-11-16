<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class CommonSupplyTransaction extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'tcode',
        'risnum',
        'entity',
        'fund',
        'division',
        'office',
        'ccode',
        'purpose',
        'requester_id',
        'requester',
        'position_req',
        'date_req',
        'sign_req',
        'approver_id',
        'approver',
        'position_app',
        'date_app',
        'sign_app',
        'assessor_id',
        'assessor',
        'position_ass',
        'date_ass',
        'sign_ass',
        'issuer_id',
        'issuer',
        'position_iss',
        'date_iss',
        'sign_iss',
        'receiver_id',
        'receiver',
        'position_rec',
        'date_rec',
        'sign_rec',
        'status',
        'ris_generation',
        'overall_total',
        'archive',
        'accepted',
        'submitted',
        'type',
        'approved',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'tcode',
                'risnum',
                'entity',
                'fund',
                'division',
                'office',
                'ccode',
                'purpose',
                'requester_id',
                'requester',
                'position_req',
                'date_req',
                'sign_req',
                'approver_id',
                'approver',
                'position_app',
                'date_app',
                'sign_app',
                'assessor_id',
                'assessor',
                'position_ass',
                'date_ass',
                'sign_ass',
                'issuer_id',
                'issuer',
                'position_iss',
                'date_iss',
                'sign_iss',
                'receiver_id',
                'receiver',
                'position_rec',
                'date_rec',
                'sign_rec',
                'status',
                'ris_generation',
                'overall_total',
                'archive',
                'accepted',
                'submitted',
                'type',
            ]) // log only these fields
            ->useLogName('supplies_transaction')         // set a custom log name
            ->logOnlyDirty()                 // log only changed values
            ->setDescriptionForEvent(fn(string $eventName) => "Supply request was {$eventName}");
    }
}
