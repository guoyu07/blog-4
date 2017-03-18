@extends('layouts.app')

@section('content')
<div class="container">
    

<div class="row">
    <main class="col-md-6 col-md-offset-3 ">
        <article>
         <header>
                <h1>{{ $article->title }}</h1>
                <section>
                    <time title="{{ $article->created_at }}"><i class="fa fa-clock-o" aria-hidden="true"></i> {{ $article->created_at }}</time>
                </section>

                 <section >
                    {!! $article->content !!}
                </section>
            </header>

            <footer >
                    分类：<a href=""> {{ $article->tag->tags }}</a>
                        @if(!Auth::guest() && Auth::user()->id == $article->user_id)
                        | <a href="{{action('ArticleController@create', ['article_id'=>$article->id ])}}"> 修改文章</a>
                        | <a href="{{action('ArticleController@index')}}" target="_blank"> 后台查看</a>
                        @endif
            </footer>
        </article>
    </main>
</div>
@if (count($article->comment) > 0)
<div class="row">
    <main class="col-md-6 col-md-offset-3 ">
@foreach($article->comment as $comment)
<div class="row">
  <div class="col-xs-6 col-md-4">
    <img src="{{asset($comment->user->image_url)}}" style="width: 50px;height: 50px">{{$comment->user->name}}
  </div>
    <div class="col-xs-12 col-sm-6 col-md-8">
    {{$comment->content}}
    @if (!Auth::guest() && Auth::user()->id == $comment->user_id)
    <form method="POST" action="{{action('CommentController@destroy', ['comment_id'=>$comment->id ])}}" accept-charset="UTF-8" >
     <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input type="submit" value="删除" class="btn btn-default btn-xs" >
    </form>
    @endif
    </div>

</div>
@endforeach
</main>
</div>
@endif
<form method="POST" action="{{url('post_comment')}}" accept-charset="UTF-8" >
<div class="row">
    <main class="col-md-6 col-md-offset-3 ">
    <textarea rows="5" name="comment" required="required" placeholder="评论" style="margin: 0px; height: 100px; width: 613px;"></textarea>
    <input type="hidden" name="article_id" value="{{$article->id}}" >
     <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="submit" value="提交" class="btn btn-primary" >
    </main>
</div>
</form>
@endsection
</div>