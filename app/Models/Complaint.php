<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        'name',
        'number_phone',
        'address',
        'complaint_type_id',
        'division_id',
        'date',
        'status',
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
