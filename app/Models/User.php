<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const ADMIN = 1;
    const NORMAL = 0;
    const BANNED = 1;
    const ACTIVE = 0;

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

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public static function add($fields) {
        $user = new static();
        $user->fill($fields);
        $user->password = bcrypt($fields['password']);
        $user->save();

        return $user;
    }

    public function edit($fields) {

        $this->fill($fields);
        if ($fields['password']) {
            $this->password = bcrypt($fields['password']);
        }
        $this->save();

        return $this;
    }

    public function remove() {
        Storage::delete('uploads/' . $this->image);
        $this->delete();
    }

    public function toggleAdmin($value) {
        if ($value) {
            $this->makeAdmin();
        } else {
            $this->makeNormal();
        }

        return $this;
    }

    public function makeAdmin() {
        $this->is_admin = static::ADMIN;
        $this->save();
        return $this;
    }

    public function makeNormal() {
        $this->is_admin = static::NORMAL;
        $this->save();
        return $this;
    }

    public function toggleBan($value) {
        if ($value) {
            $this->ban();
        } else {
            $this->unban();
        }

        return $this;
    }

    public function ban() {
        $this->status = static::BANNED;
        $this->save();
        return $this;
    }

    public function unban() {
        $this->status = static::ACTIVE;
        $this->save();
        return $this;
    }

    public function uploadAvatar($image) {

        if ($image) {
            if ($this->image) {
                Storage::delete('/uploads/' . $this->image);
            }

            $filename = Str::random(10) . '.' . $image->extension();
            $image->storeAs('/uploads/', $filename);
            $this->image = $filename;
            $this->save();
        }
    }

    public function getAvatar() {
        $image = '';

        if ($this->image) {
            $image = '/uploads/'.$this->image;
        } else {
            $image = '/img/no-user-image.png';
        }

        return $image;
    }
}
