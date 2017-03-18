<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Flash;
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
        $user_id = Auth::user()->id;
        $articles = Blog::getUserArticles($user_id);
        return view('articles.articlesList', compact('articles'));
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
        return view('create_edit_articles', compact('respondata'));
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
        if ($respondata) {
            Flash::success('创建成功');
            return redirect()->action('ArticleController@show', ['id' => $respondata['id']]);
        }
        Flash::error('创建失败');
        return redirect()->back()->withInput($request->input());
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
        if ($article->is_blocked == 1 && (Auth::guest() || Auth::user()->id != $article->user_id)) {
            return view('articles.error');
        }
        return view('articles.article', compact('article'));
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
        if ($respondata) {
            Flash::success('更新成功');
            return redirect()->action('ArticleController@show', ['id' => $respondata['id']]);
        }
        Flash::error('更新失败');
        return redirect()->back()->withErrors($validator)->withInput($request->input());
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
        Flash::error('更新失败');
        if ($res) {
            Flash::success('更新成功');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user_id = Auth::user()->id;
        $res = Blog::delArticle($request->id, $user_id);
        Flash::error('创建失败');
        if ($res) {
            Flash::success('删除成功');
        }
        return redirect()->back();
    }

    public function home()
    {
        $articles = Blog::getAllArticles();
        return view('home', compact('articles'));
    }

    public function userHome()
    {
        $user_id = Auth::user()->id;
        $articles = Blog::getAllArticles();
        $noti_count = Blog::getCommentNotifiction($user_id);
        return view('home', compact('articles'));

        dd($articles, $noti_count);
    }
}
