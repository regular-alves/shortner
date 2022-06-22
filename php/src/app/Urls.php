<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Urls extends Model
{
    use SoftDeletes;

    protected $table = 'urls';
    protected $fillable = [ 'url', 'shortname', 'title' ];
    protected $hidden = [ 'deleted_at' ];

    public function activity()
    {
        return $this->hasMany( UrlActivities::class, 'url_id', 'id' );
    }
}
