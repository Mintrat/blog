<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    const DISALLOW = 0;
    const ALLOW = 1;

    public function post() {
        return $this->hasOne(Post::class);
    }

    public function author() {
        return $this->hasOne(User::class);
    }

    public function toggleAllow() {
        if ($this->status == static::ALLOW) {
            $this->disallow();
        } else {
            $this->allow();
        }

        return $this;
    }

    public function allow() {
        $this->status = static::ALLOW;
        $this->save();
        return $this;
    }

    public function disallow() {
        $this->status = static::DISALLOW;
        $this->save();
        return $this;
    }

    public function remove() {
        $this->delete();
    }
}
