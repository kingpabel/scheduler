<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Schedule extends Model {
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'schedule';

    public $timestamps = true;

    protected $fillable = array('*');


    public function newQuery($company_id = true)
    {
        $query = parent::newQuery($company_id);
        $query->where('user_id', '=', Auth::user()->id);
        return $query;
    }

    /* Start Boot */
    public static function boot()
    {
        parent::boot();

        static::creating(function($post)
        {
            $post->created_by = Auth::user()->id;
            $post->updated_by = Auth::user()->id;
        });

        static::updating(function($post)
        {
            $post->updated_by = Auth::user()->id;
        });
    }/* END Boot */
}
