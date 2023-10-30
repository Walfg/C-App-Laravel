<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $table = "contacts";
    use HasFactory;

    protected $fillable = [
        "name",
        "phone_number",
        "email",
        "age",
        "user_id"
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
