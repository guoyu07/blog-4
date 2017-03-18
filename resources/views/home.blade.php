@extends('layouts.app')

@section('content')
<div class="container">
<div class="row">
    @if(count($articles) > 0)
    @foreach ($articles as $article)
    <div class="col-xs-9">
        <div class="col-xs-2">
         <img  src="{{asset($article->user->image_url)}}" style="width: 50px; height: 50px;">{{$article->user->name}}</div>
        <div class="col-xs-8"><a href="{{action('ArticleController@show', ['article_id'=>$article->id ])}}">{{$article->title}}</a></div>
    </div>
    @endforeach
    @else
    <h2>暂无文章</h2>
    @endif
</div>
</div>
@endsection
