@extends('layouts.app')

@section('content')
<div class="container">
<table class="table table-condensed">
<tr>
    <td>ID</td>    
    <td>标题</td>    
    <td>分类</td>    
    <td>作者</td>    
    <td>create_at</td>
    <td>管理</td>    
</tr>
    @foreach ($articles as $article)
        @if($article->is_blocked == 1)
        <tr class="warning">
        @else 
        <tr>
        @endif
        <td>{{$article->id}}</td>
        <td><a href="{{action('ArticleController@show', ['article_id'=>$article->id ])}}">{{$article->title}}</a></td>
        <td>{{$article->tag->tags}}</td>
        <td>{{$article->user->name}}</td>
        <td>{{$article->created_at}}</td>
        <td>
         <form method="POST" action="{{action('ArticleController@destroy', ['id'=>$article->id ])}}" accept-charset="UTF-8" >
             <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="submit" value="删除" class="btn btn-default btn-xs" >
            </form>
        <a href="{{action('ArticleController@create', ['article_id'=>$article->id ])}}"> 编辑</a>
        
        <a href="{{action('ArticleController@update', ['id'=>$article->id ])}}"> @if($article->is_blocked == 1)发布 @else 转草稿@endif</a>        
        </td>
        </tr>
    @endforeach
</table>
</div>
@endsection