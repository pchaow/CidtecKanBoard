<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lane extends Model
{
    //get all card in lane
    public function cards()
   {
       return $this->hasMany('App\Models\Card','lanes_id','id');
   }

  //get board where lane live
   public function board()
  {
      return $this->belongsTo('App\Models\Board', 'boards_id');
  }

}
