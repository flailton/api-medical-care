<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'professional_id',
        'appointment_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * The procedures that belong to the appointment.
     */
    public function procedures()
    {
        return $this->belongsToMany(Procedure::class);
    }

    /**
     * Get the user associated with the appointment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the professional associated with the appointment.
     */
    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }
}
