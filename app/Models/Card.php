<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Card
 *
 * @property-read \App\Models\Lane $lane
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $membersCard
 * @property-read \App\Models\User $ownerCard
 * @mixin \Eloquent
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property int $rank
 * @property int $lanes_id
 * @property int $user_id
 * @property string|null $startdate
 * @property string|null $duedate
 * @property array $checklists
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card whereChecklists($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card whereDuedate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card whereLanesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card whereRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card whereStartdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card whereUserId($value)
 */
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
