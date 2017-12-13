<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Taxonomy extends Model
{
    //
    protected $table = 'taxonomy';
    protected $primaryKey = 'taxonomy_id';
    protected $fillable = ['name', 'slug', 'type', 'parent', 'count'];

    public function parent()
    {
    	return $this->belongsTo('App\Taxonomy', 'parent', 'taxonomy_id');
    }

    public function term_meta()
    {
    	return $this->hasMany('App\TermMeta', 'term_meta_id', 'taxonomy_id');
    }
}
