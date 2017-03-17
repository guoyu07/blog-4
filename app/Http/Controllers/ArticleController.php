<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Blog;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Blog::getUserArticles($user_id);
        dd($articles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // $article_id = null;
        $article_id = $request->get('article_id');
        $user_id = Auth::user()->id;
        $respondata = Blog::getCreateOrUpdateArticles($article_id, $user_id);
        dd($respondata);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
/*        $data = [
            'title' => "哇哈哈",
            'intro' => "哈哈哈哇",
            'tags_id' => 1,
            'tag_name' => "",
            'is_blocked' => 0,
            'content' => "呜啦啦啦呜啦啦啦"
        ];*/
        $data = $request->input();
        $data['is_create'] = true;
        $user_id = Auth::user()->id;
        $respondata = Blog::createOrUpdateArticles($data, $user_id);
        dd($respondata);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Blog::getArticleById($id);
        dd($article);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
/*        $data = [
            'title' => "哇哈哈",
            'intro' => "哈哈哈哇",
            'tags_id' => 1,
            'tag_name' => "test4",
            'is_blocked' => 0,
            'content' => "呜啦啦啦呜啦啦啦"
        ];*/
        $data = $request->input();
        $data['is_create'] = false;
        $data['article_id'] = $id;
        $user_id = Auth::user()->id;
        $respondata = Blog::createOrUpdateArticles($data, $user_id);
        dd($respondata);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user_id = Auth::user()->id;
        $res = Blog::updateArticle($id, $user_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_id = Auth::user()->id;
        $res = Blog::delArticle($request->id, $user_id);
        return $res;
    }
}
