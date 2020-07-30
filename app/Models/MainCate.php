<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class MainCate extends Model
{
    // NOTIFICATION CLASS
    use Notifiable;

    // MODEL TABLE NAME IN DB;
    protected $table = 'main_cates';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'trans_lang',
        'trans_of',
        'name',
        'slug',
        'photo',
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

}
