<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Complaint extends Model
{
    use SoftDeletes;

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
        return $this->belongsTo(ComplaintType::class)->withTrashed();
    }

    public function division()
    {
        return $this->belongsTo(Division::class)->withTrashed();
    }
}
