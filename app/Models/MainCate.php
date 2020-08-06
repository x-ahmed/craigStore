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

    // LOCAL SELECTION SCOPE
    public function scopeSelection($query)
    {
        return $query->select(
            'id',
            'trans_lang',
            'trans_of',
            'name',
            'slug',
            'photo',
            'status'
        );
    }

    // STATUS METHOD
    public function getStatus()
    {
        // ACTIVE FOR 1 AND PENDING FOR 0
        return $this->status == 1? 'Active': 'Pending';
    }

    // PHOTO ACCESSOR
    public function getPhotoAttribute($val)
    {
        // ASSET THE IMAGE ACTUAL PATH
        return ($val != null)? asset('assets/' .$val): '';
    }

    // // MAIN CATEGORY TRANSLATION LANGUAGE ACCESSOR
    // public function getTransLangAttribute($val)
    // {
    //     // CHECK VALUE IS ARABIC
    //     if ($val == 'AR') {
    //         return 'العربيه';
    //     }
    //     // CHECK VALUE IS ENGLISH
    //     else if ($val == 'EN') {
    //         return 'English';
    //     }
    // }

    // MAIN CATEGORY NAME MUTATOR FOR FIRST LETTER UPPERCASE(CREATE FORM)

    // MAIN CATEGORU TRANSLATION LANGUAGE MUTATOR FOR UPPERCASE(CREATE FORM)

    // CATERGORIES RELATION WITH TRANLATION LANGUAGES.
    public function trans_cates()
    {
        // RETURN ONE MORE TRANSLATED CATEGORY
        return $this->hasMany(self::class, 'trans_of');
    }

}
