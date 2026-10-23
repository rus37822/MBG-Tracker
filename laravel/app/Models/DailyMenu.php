<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyMenu extends Model
{
    protected $fillable = [
        'menu_date',
        'foto',
    ];
}
