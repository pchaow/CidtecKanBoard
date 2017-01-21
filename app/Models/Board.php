<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    //get list of lanes
    public function lanes()
   {
       return $this->hasMany('App\Models\Lane','boards_id','id');
   }

   //get all member in board
   public function mamebersBoard()
  {
      return $this->belongsToMany('App\Models\User','board_user','boards_id','users_id');
  }

   //get  board owner
  public function OwnerBoard()
 {
     return $this->belongsTo('App\Models\User', 'user_id');
 }


}