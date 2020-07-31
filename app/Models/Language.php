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

    // NAME MUTATOR
    public function setNameAttribute($val)
    {
        // CONVERT LANGUAGE NAME FIRST LETTER TO UPPERCASE
        $this->attributes['name'] = ucfirst($val);
    }
    
    // ABBREVIATION MUTATOR
    public function setAbbrAttribute($val)
    {
        // CONVERT THE LANGUAGE ABBREVIATION TO UPPERCASE
        $this->attributes['abbr'] = strtoupper($val);
    }

    /*
    ** CHANGED FROM AN ACCESSOR TO
    ** NORMAL METHOD AS THE ACCESSOR
    ** IS NOT WORKING FOR THE IF CONDITION
    ** IN THE EDIT FORM WITH THE CHECKBOX INPUT
    */
    
    // STATUS ACCESSOR
    public function getStatus()
    {
        // ACTIVE FOR 1 AND PENDING FOR 0
        return $this->status == 1? 'Active': 'Pending';
    }

    /*
    ** ASSIGNS MESSAGES FOR THE DB VALUE
    ** WHERE "ltr" MESSAGE IS "From left to right"
    ** AND "rtl" MESSAGE IS "From right to left"
    */

    // DIRECTION ACCESSOR
    public function getDirectionAttribute($val)
    {
        // RETURN THE ASSIGNED MESSAGES
        return $val == "ltr"? 'From left to right': 'From right to left';
    }

}
