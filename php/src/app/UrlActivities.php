<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UrlActivities extends Model
{
    protected $table = 'url_activities';
    protected $fillable = [ 'url_id' ];

    public function url()
    {
        return $this->belongsTo( Urls::class, 'url_id', 'id' );
    }
}
