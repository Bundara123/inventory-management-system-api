<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'photo',
        'account_holder',
        'account_number',
        'bank_name',
    ];

    protected $casts = [
        'created_at' => 'datetime', 'updated_at' => 'datetime',
    ];

    public function quotations(): HasMany
    {
        return $this->HasMany(Quotation::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
