<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Lane
 *
 * @property-read \App\Models\Board $board
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Card[] $cards
 * @mixin \Eloquent
 * @property int $id
 * @property string|null $name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $board_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lane whereBoardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lane whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lane whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lane whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lane whereUpdatedAt($value)
 */
class Lane extends Model
{
    protected $fillable = ['name', 'board_id'];
    //get all card in lane
    public function cards()
   {
       return $this->hasMany(Card::class,'lanes_id','id')
       ->orderBy('rank');
   }

  //get board where lane live
   public function board()
  {
      return $this->belongsTo(Board::class, 'boards_id');
  }

}
