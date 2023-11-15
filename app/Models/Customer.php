<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'company_id',
        'trial_ends_at',
        'next_cycle_date',
        'stripe_id',
        'user_number',
        'billing_contact_email',
        'is_premium',
    ];
}
