<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TermMeta extends Model
{
    //
    protected $table = 'term_meta';
    protected $primaryKey = 'term_meta_id';
    protected $fillable = ['taxonomy_id', 'meta_key', 'meta_value'];

    public function taxonomy()
    {
    	return $this->belongsTo('App\Taxonomy', 'term_meta_id', 'taxonomy_id');
    }
}
