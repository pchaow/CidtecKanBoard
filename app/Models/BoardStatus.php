<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BoardStatus
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string|null $name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BoardStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BoardStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BoardStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BoardStatus whereUpdatedAt($value)
 */
class BoardStatus extends Model
{
    protected $table="board_statuses";
}
