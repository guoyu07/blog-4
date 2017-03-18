@extends('layouts.app')

@section('content')
@include('vendor.ueditor.assets')
<div class="container">
    <h2 class="text-center">{{ $respondata['is_create']? '新建文章' : '编辑文章' }}</h2>
</div>
@if ($respondata['is_create'])
<form method="POST" action="{{url('post_articles')}}" accept-charset="UTF-8" >
@else
    <form method="POST" action="{{action('ArticleController@edit', ['id' =>$respondata['article']['id']])}}" accept-charset="UTF-8">
@endif
<!-- 文章标题 -->
<div class="container">
    <div class="form-group">
        <input class="form-control" id="article-title" placeholder="文章标题" name="title" type="text" value="{{ old('title') ?: $respondata['article']['title'] }}" required="require">
    </div>
</div>
<!-- 文章简介 -->
<div class="container">
    <div class="form-group">
        <input class="form-control" id="article-intro" placeholder="文章简介" name="intro" type="text" value="{{ old('intro') ?: $respondata['article']['intro'] }}" required="require">
    </div>
</div>
<!-- 文章分类 -->
<div class="container">
         @if(count($respondata['tags'] )> 0)
        <div class="form-group">
            <select class="selectpicker form-control" name="tags_id" id="category-select">
              @if ($respondata['article']['tags_id'] == 0 )
              <option value="" disabled {{ count($respondata['tags'] )> 0 ?: 'selected' }}>请选择分类</option>
              @endif
                  @foreach ($respondata['tags'] as $value)
                      <option value="{{ $value[0]->id }}" {{ ($respondata['article']['tags_id'] != 0 && $value[0]->id == $respondata['article']['tags_id']) ? 'selected' : '' }} >{{ $value[0]->tags }}</option>
                  @endforeach
            </select>
        </div>
            @endif
</div>
<div class="container">
    <div class="form-group">
        <input class="form-control" id="article-intro" placeholder="{{ count($respondata['tags'] )> 0?"新增分类，无需新增时至空":"新增分类" }}" name="tag_name" type="text" value="{{ old('tag_name') }}">
    </div>
</div>
<div class="container">
    <div class="form-group">
        <select class="selectpicker form-control" name="is_blocked" id="blocked-select">
          <option value="0">发布</option>
          <option value="1">存草稿</option>
        </select>
    </div>
</div>
<div class="container">
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var ue = UE.getEditor('container');
        ue.ready(function() {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
    </script>

    <!-- 编辑器容器 -->
    <script id="container" name="content" type="text/plain" >{!! $respondata['article']['content'] !!}</script>
</div>
 <input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="container">
    <div class="form-group status-post-submit">
      <input class="btn btn-primary" id="post-create-submit" type="submit" value="确定">
    </div>
</div>
</form>
@endsection