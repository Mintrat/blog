<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\This;


class Post extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = ['title', 'content'];
    const IS_DRAFT = 0;
    const IS_PUBLIC = 1;
    const IS_FEATURED = 1;
    const IS_STANDART = 0;
    public function category()
    {
        return $this->hasOne(Category::class);
    }

    public function author() {
        return $this->hasOne(User::class);
    }

    public function tags() {
        return $this->belongsToMany(Tag::class, 'posts_tags', 'post_id', 'tag_id');
    }

    public static function add($fields) {
        $post = new static();
        $post->fill($fields);
        $post->user_id = 1;
        $post->save();
        return $post;
    }

    public function setCategory($categoryID) {
        if ($categoryID) {
            $this->category_id = $categoryID;
            $this->save();
            return $this;
        }
    }

    public function setTag($tagIDs) {
        if ($tagIDs) {
            $this->tags()->sync($tagIDs);
            return $this;
        }
    }

    public function setDraft() {
        $this->status = static::IS_DRAFT;
        $this->save();
        return $this;
    }

    public function setPublic() {
        $this->status = static::IS_PUBLIC;
        $this->save();
        return $this;
    }

    public function toggleStatus($value)
    {
        if ($value) {
            $this->setPublic();
        } else {
            $this->setDraft();
        }

        return $this;
    }

    public function setFeatured() {
        $this->is_fetured = static::IS_FEATURED;
        return $this;
    }

    public function setStandart() {
        $this->is_fetured = static::IS_STANDART;
        return $this;
    }

    public function toggleFeatured($value)
    {
        if ($value) {
            $this->setFeatured();
        } else {
            $this->setStandart();
        }

        return $this;
    }

    public function edit($fields) {
        $this->fill($fields);
        $this->save();
        return $this;
    }

    public function remove() {
        Storage::delete('uploads/' . $this->image);
        $this->delete();
    }

    public function uploadImage($image) {

        if ($image) {
            Storage::delete('uploads/' . $this->image);
            $filename = Str::random(10) . '.' . $image->extension();
            $image->saveAs('uploads', $filename);
            $this->image = $filename;
            $this->save();
        }
    }

    public function getImage() {
        $image = '';

        if ($this->image) {
            $image = '/uploads/'.$this->image;
        } else {
            $image = 'img/no-user-image.png';
        }

        return $image;
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
