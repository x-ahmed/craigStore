<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Language extends Model
{
    // NOTIFICATION CLASS
    use Notifiable;

    // MODEL TABLE NAME IN DB;
    protected $table = 'languages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'abbr',
        'locale',
        'name',
        'direction',
        'status',
        'created_at',
        'updated_at',
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

    // LOCAL ACTIVE SCOPE
    public function scopeActive($query){
        return $query->where(
            'status',
            '=',
            1
        );
    }

    // LOCAL SELECTION SCOPE
    public function scopeSelection($query)
    {
        return $query->select(
            'id',
            'abbr',
            'name',
            'direction',
            'status'
        );
    }

    // STATUS ACCESSOR
    public function getStatusAttribute($val)
    {
        // ACTIVE FOR 1 AND PENDING FOR 0
        return $val == 1? 'Active': 'Pending';
    }

}
