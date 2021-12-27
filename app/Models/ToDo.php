<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class ToDo extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

    public function user()
    {
        return $this->BelongsTo(User::class);
    }

    public function isValid()
    {
        return ($this->user_id == Auth::user()->id) ? true : false;
    }
}
