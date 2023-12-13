<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Admin extends Model
{
    use Notifiable;

    protected $guarded = ['id'];
    protected $table = 'admins';
    // protected $guarded = array();
    protected $hidden = [
        'password'
    ];
    public function getAuthPassword()
    {
        return $this->password;
    }
    protected $fillable = ['name', 'email', 'password', 'phone_no'];
}
