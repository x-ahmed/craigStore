<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class SubCate extends Model
{
    // NOTIFICATION CLASS
    use Notifiable;

    // MODEL TABLE NAME IN DB;
    protected $table = 'sub_cates';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'trans_lang',
        'trans_of',
        'parent_id',
        'cate_id',
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
        'cate_id',
        'created_at',
        'updated_at',
    ];

    // OVERRIDE MODEL "boot()" METHOD FOR OBSERVER
    protected static function boot()
    {
        parent::boot();

        // BIND RELATIONSHIP OF "SubCate" MODEL WITH "SubCateObserver" OBSERVER
        SubCate::observe(SubCateObserver::class);
    }

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
            'parent_id',
            'cate_id',
            'trans_lang',
            'trans_of',
            'name',
            'slug',
            'photo',
            'status'
        );
    }

    // LOCAL DEFAULT LANGUAGE CATEGORY SCOPE
    public function scopeDefLangCate($query)
    {
        return $query->where(
            'trans_of',
            '=',
            0
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

    // MAIN CATEGORY NAME MUTATOR FOR FIRST LETTER UPPERCASE(CREATE FORM)

    // MAIN CATEGORU TRANSLATION LANGUAGE MUTATOR FOR UPPERCASE(CREATE FORM)

    // TRANSLATED CATEGORIES RELATIONSHIP WITH THEIR SUB CATEGORY
    public function trans_cates()
    {
        // RETURN ONE OR MORE TRANSLATED CATEGORY
        return $this->hasMany(
            self::class,
            'trans_of',
            'id'
        );
    }

    // SUB CATEGORY RELATIONSHIP WITH THEIR RELATED TRANSLATED CATEGORIES
    public function def_cate()
    {
        // RETURN THE ONLY SUB CATEGORY OF THESE TRANSLATED ONES
        return $this->belongsTo(
            self::class,
            'translation_of',
            'id'
        );
    }

    // SUB CATEGORIES RELATIONSHIP WITH VENDORS
    public function vendors()
    {
        // RETURN THE ONE OR MORE RELATED VENDORS
        return $this->hasMany(
            Vendor::class,
            'cate_id',
            'id'
        );
    }

}
