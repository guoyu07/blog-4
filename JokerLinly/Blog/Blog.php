<?php

namespace JokerLinly\Blog;

use JokerLinly\Blog\Factory\ArticleFactory;

/**
* 
*/
class Blog 
{
    public static function getCreateOrUpdateArticles($article_id, $user_id)
    {
        $article = [
            'id'         => 0,
            'title'      => '',
            'intro'      => '',
            'content'    => '',
            'tags_id'    => 0,
            'is_blocked' => 0
        ];
        $tags    = [];
        $is_create = true;
        if (!empty($user_id)) {
            $tags = ArticleFactory::getTagsByUserId($user_id)->groupBy('id');
            if (count($tags) ==0) {
                $tags = [];
            }
        }
        if (!empty($article_id)) {
            $is_create = false;
            $article_info = ArticleFactory::getArticleInfoById($article_id);
            $article = [
                'id'         => $article_info->id,
                'title'      => $article_info->title,
                'intro'      => $article_info->intro,
                'content'    => $article_info->content,
                'tags_id'    => $article_info->tags_id,
                'is_blocked' => $article_info->is_blocked,
                "tags_name"  => $tags[$article_info->tags_id][0]['tag'],
            ];
            foreach ($tags as $key => $value) {
                if (empty($article_info->tags_id) && $key ==  $article_info->tags_id) {
                    unset($tags[$key]);
                }
            }
        }
        return [
            'is_create' => $is_create,
            'article'   => $article,
            'tags'      => $tags,
        ];
    }

    public static function createOrUpdateArticles($data, $user_id)
    {
        if (!empty(trim($data['tag_name']))) {
            $tags_id = ArticleFactory::addArticleTags($data['tag_name'], $user_id);
            $data['tags_id'] = $tags_id;
        } 
        return  ArticleFactory::addOrUpdateArticle($data, $user_id);
    }

    public static function getArticleById($article_id)
    {
        return  ArticleFactory::getArticleById($article_id);
    }

    public function addComment($data, $user_id)
    {
        if (isset($data['article_id']) && $data['article_id'] != 0) {
            $data['comment_id'] = 0;
        }
        if (isset($data['comment_id']) && $data['comment_id'] != 0) {
            $data['article_id'] = 0;
        }
        $res = ArticleFactory::addComment($data, $user_id);
        if (!$res) {
            return $res;
        }
        return $res;
    }

    public function updateArticle($id, $user_id)
    {
        $article = ArticleFactory::getArticleByTwoId($id, $user_id);
        if (!$article) {
            return  false;
        }
        if ($article->is_blocked == 1) {
            $article->is_blocked = 0;
        } else {
            $article->is_blocked = 1;
        }
        return $article->save();
    }

    public static function delArticle($id, $user_id)
    {
        return ArticleFactory::delArticle($id, $user_id);
    }

    public static function getUserArticles($user_id)
    {
       return  ArticleFactory::getUserArticleById($user_id);
    }
}