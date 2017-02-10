<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{

  protected $fillable = ['name', 'description', 'user_id'];

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
  public function user()
 {
     return $this->belongsTo(User::class, 'user_id');
 }


}
