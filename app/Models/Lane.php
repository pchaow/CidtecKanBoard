<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lane extends Model
{
    //get all card in lane
    public function cards()
   {
       return $this->hasMany(Card::class,'lanes_id','id');
   }

  //get board where lane live
   public function board()
  {
      return $this->belongsTo(Board::class, 'boards_id');
  }

}
