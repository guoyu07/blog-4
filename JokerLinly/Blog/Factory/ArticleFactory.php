<?php
namespace JokerLinly\Blog\Factory;
use JokerLinly\Blog\Models\Article;
use JokerLinly\Blog\Models\ArticleTag;
use JokerLinly\Blog\Models\Comment;
use JokerLinly\Blog\Models\User;

/**
* 
*/
class ArticleFactory
{
    public static function getArticleInfoById($id)
    {
        return Article::find($id);
    }

    public static function getTagsByUserId($user_id)
    {
        return ArticleTag::where('user_id', $user_id)->get();
    }

    public static function addArticleTags($tag, $user_id)
    {
        $is_exits = ArticleTag::where('user_id', $user_id)->where('tags', $tag)->first();
        if ($is_exits) {
            return $is_exits->id;
        }
        $type = new ArticleTag;
        $type->tags = $tag;
        $type->user_id = $user_id;
        $res = $type->save();
        if ($res) {
            return $type->id;
        }
        return $res;
    }

    public static function addOrUpdateArticle($data, $user_id)
    {
        if ($data['is_create']) {
            $article = new Article;
        } else {
            $article = Article::where('user_id', $user_id)->where('id', $data['article_id'])->first();
            if (!$article) {
                return false;
            }     
        }
        $article->title = $data['title'];
        $article->intro = $data['intro'];
        $article->content = $data['content'];
        $article->tags_id = $data['tags_id'];
        $article->user_id = $user_id;
        $article->is_blocked = $data['is_blocked'];
        $res = $article->save();
        if (!$res) {
            return $res;
        }
        return $article;
    }

    public static function getArticleById($article_id)
    {
        return Article::where('id', $article_id)
            ->with(['tag', 'comment', 'comment.user'])
            ->first();
    }

    public static function addComment($data, $user_id)
    {
        $comment = new Comment;
        $comment->content = $data['comment'];
        $comment->article_id = $data['article_id'];
        $comment->comment_id = $data['comment_id'];
        $comment->user_id = $user_id;
        return $comment->save();
    }

    public static function getArticleByTwoId($id, $user_id)
    {
        return Article::where('id', $id)->where('user_id', $user_id)->first();
    }

    public static function delArticle($id, $user_id)
    {
        return Article::where('id', $id)->where('user_id', $user_id)->delete();
    }

    public static function getUserArticleById($user_id)
    {
        return Article::where('user_id', $user_id)
            ->with(['tag', 'user', 'comment', 'comment.user'])->get();
    }

    public static function getAllArticles()
    {
        return Article::where('is_blocked', 0)
            ->with(['tag', 'comment', 'comment.user'])->get();
    }

    public static function getCommentNotifiction($user_id)
    {
        return Comment::where('is_read', 0)
            ->whereHas('article', function ($query) use ($user_id){
                $query->where('user_id', $user_id);
            })
            ->count();
    }
}
