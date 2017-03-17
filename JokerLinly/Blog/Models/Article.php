<?php

namespace JokerLinly\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    public function tag()
    {
        return $this->belongsTo(ArticleTag::class, 'tags_id', 'id');
    }    

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function comment()
    {
        return $this->hasMany(Comment::class, 'article_id', 'id');
    }
}
