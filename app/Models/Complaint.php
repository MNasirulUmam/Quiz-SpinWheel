<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        'complaint_code',
        'name',
        'number_phone',
        'address',
        'attachment',
        'description',
        'complaint_type_id',
        'division_id',
        'date',
        'status',
        'notes',
    ];

    public function complaintType()
    {
        return $this->belongsTo(ComplaintType::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
