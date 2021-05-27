<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Borrow;
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function borrows() {
        return $this->hasMany(Borrow::class,'reader_id');
    }

    public function librarian_requested_borrows() {
        return $this->hasMany(Borrow::class,'request_managed_by');
    }

    public function librarian_returned_borrows() {
        return $this->hasMany(Borrow::class,'return_managed_by');
    }

    public function isLibrarian(){
        return $this->is_librarian;
    }
}
