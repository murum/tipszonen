<?php

class Product extends Eloquent {
    protected $fillable = [];

    public function matches()
    {
        return $this->hasMany('Match');
    }
}