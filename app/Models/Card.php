<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = ['name', 'description','rank', 'user_id', 'lanes_id', 'startdate', 'duedate', 'checklists'];

    //get  card owner
    public function ownerCard()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    //get Lane of card
    public function lane()
    {
        return $this->belongsTo('App\Models\Lane', 'lanes_id');
    }

    //get all member in card
    public function membersCard()
    {
        return $this->belongsToMany('App\Models\User', 'card_user', 'cards_id', 'users_id');
    }

    protected $casts = [
        'checklists' => 'array',
    ];

}
