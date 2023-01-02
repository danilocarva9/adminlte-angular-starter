<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecoveryPassword extends Model
{

    protected $table = 'recovery_passwords';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'encryption', 'is_active', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', '=', 1);
    }

}
