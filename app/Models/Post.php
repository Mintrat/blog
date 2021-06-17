<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class Post extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = ['title', 'content', 'date', 'description'];
    const IS_DRAFT = 0;
    const IS_PUBLIC = 1;
    const IS_FEATURED = 1;
    const IS_STANDART = 0;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tags() {
        return $this->belongsToMany(Tag::class, 'posts_tags', 'post_id', 'tag_id');
    }

    public static function add($fields)
    {
        $post = new static();
        $post->fill($fields);
        $post->save();
        return $post;
    }

    public function setCategory($categoryID)
    {
        if ($categoryID) {
            $this->category_id = $categoryID;
            $this->save();
            return $this;
        }
    }

    public function setTags($tagIDs)
    {
        if ($tagIDs) {
            $this->tags()->sync($tagIDs);
            return $this;
        }
    }

    public function setDraft()
    {
        $this->status = static::IS_DRAFT;
        $this->save();
        return $this;
    }

    public function setPublic()
    {
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

    public function setFeatured()
    {
        $this->is_featured = static::IS_FEATURED;
        return $this;
    }

    public function setStandart()
    {
        $this->is_featured = static::IS_STANDART;
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

    public function edit($fields)
    {
        $this->fill($fields);
        $this->save();
        return $this;
    }

    public function remove()
    {
        $this->removeImage();
        $this->delete();
    }

    public function uploadImage($image)
    {
        if (!$image) return;
        $this->removeImage();
        Storage::delete('uploads/' . $this->image);
        $filename = Str::random(10) . '.' . $image->extension();
        $image->storeAs('uploads', $filename);
        $this->image = $filename;
        $this->save();
    }

    public function getImage()
    {

        if ($this->image) {
            $image = '/uploads/'.$this->image;
        } else {
            $image = '/img/no-user-image.png';
        }
        return $image;
    }

    public function getCategoryTitle()
    {
        return $this->hasCategory() ? $this->category->title : null;
    }

    public function hasCategory()
    {
        return $this->category ? true : false;
    }

    public function getTagsTitles()
    {
        $tagsTitle = $this->tags()->pluck('title')->all();
        return $tagsTitle ? implode(', ', $tagsTitle) : null;
    }

    public function removeImage()
    {
        if ($this->image != null) {
            Storage::delete('uploads/' . $this->image);
        }
    }

    public function setDateAttribute($value)
    {
        $date = Carbon::createFromFormat('d/m/y', $value)->format('Y-m-d');
        $this->attributes['date'] = $date;
    }

    public function getDateAttribute($value)
    {
        return Carbon::createFromFormat('Y-m-d', $value)->format('d/m/y');
    }

    public function getCategoryID()
    {
        return $this->category ? $this->category->id : null;
    }

    public function getDate()
    {
        return Carbon::createFromFormat('d/m/y', $this->date)->format('F d, y');
    }

    public function hasPreviousPost()
    {
        return self::where('id', '<', $this->id)->max('id');
    }

    public function getPreviousPost()
    {
        return Post::find($this->hasPreviousPost());
    }

    public function hasNextPost()
    {
        return self::where('id', '>', $this->id)->min('id');
    }

    public function getNextPost()
    {
        return Post::find($this->hasNextPost());

    }

    public function related()
    {
        return self::all()->except($this->id);
    }

    public static function getPopularPosts(int $count = null)
    {
        $posts = self::orderBy('views', 'desc')->where('status', '=', Post::IS_PUBLIC);
        if ($count) {
            $posts = $posts->take($count);
        }

        return $posts->get();
    }

    public static function getFeaturedPosts(int $count = null)
    {
        $posts = self::orderBy('views', 'desc')->where('is_featured', '=', Post::IS_FEATURED)->where('status', '=', Post::IS_PUBLIC);
        if ($count) {
            $posts = $posts->take($count);
        }

        return $posts->get();
    }

    public static function getRecentPosts(int $count = null)
    {
        $posts = self::orderBy('created_at', 'desc')->where('status', '=', Post::IS_PUBLIC);
        if ($count) {
            $posts = $posts->take($count);
        }

        return $posts->get();
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
