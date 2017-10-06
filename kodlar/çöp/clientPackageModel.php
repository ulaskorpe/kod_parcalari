<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientPackage extends Model
{
    public function client(){
        return $this->belongsTo('App\Models\Client');
    }

    public function package(){
        return $this->belongsTo('App\Models\Package');
    }
    protected $table = 'client_packages';
    protected $fillable = ['client_id','package_id'];
}
