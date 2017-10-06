<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use App\Models\Personel;
class UserFile extends Model
{
    public function user(){
      /// return Personel::where('id',$this->personel_id)->first()->personel_name;
        return $this->belongsTo('App\User');
    }

    protected $table = 'user_file';
    protected $fillable = ['description','file','date','user_id'];
}
