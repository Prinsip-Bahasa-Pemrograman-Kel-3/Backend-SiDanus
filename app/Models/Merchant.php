<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Merchant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'business_phone',
        'business_email',
        'id_card_image',
        'avatar',
        'student_id',
        'organization_id',
        'event_id'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function merchantOperationalTimes()
    {
        return $this->hasMany(MerchantOperationalTimes::class);
    }

    public function merchantSubmission()
    {
        return $this->hasMany(MerchantSubmission::class);
    }

    // public function product()
    // {
    //     return $this->hasMany(Product::class);
    // }

    // public function transaction()
    // {
    //     return $this->hasMany(Transaction::class);
    // }
}
