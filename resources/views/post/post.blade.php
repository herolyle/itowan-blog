@extends('layouts.app')

@section('content')
@include('vendor.ueditor.assets')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">博客</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ url('/post/createOrUpdate') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="title" class="col-md-2 control-label">标题</label>

                            <div class="col-md-8">
                                <input id="title" type="text" class="form-control" name="title" required autofocus value="{{isset($post) ? $post->title : ''}}">
                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="describe" class="col-md-2 control-label">简介</label>

                            <div class="col-md-8">
                                    <input id="describe" type="text" class="form-control" name="describe" autofocus  value="{{isset($post) ? $post->describe : ''}}">
                                @if ($errors->has('describe'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('describe') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-md-2 control-label">内容</label>

                            <div class="col-md-8">
                            <!-- 实例化编辑器 -->
                            <script type="text/javascript">
                                var ue = UE.getEditor('container');
                                ue.ready(function() {
                                    ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
                                });
                            </script>
                            <!-- 编辑器容器 -->
                            <script id="container" name="content" type="text/plain">
                                    {{isset($post) ? $post->content : ''}}
                            </script>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="poster" class="col-md-2 control-label">作者</label>
                            <div class="col-md-8">
                                <select id="poster" name="user_id" class="form-control">
                                    <option value="{{ isset($post) ? $post->id : $default->id}}">{{isset($post->user->name) ? $post->user->name : $default->name}}</option>
                                    @foreach ($posters as $poster)
                                            <option value="{{ $poster->id}}">{{$poster->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="id" value="{{isset($post) ? $post->id : ''}}">

                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    发布
                                </button>
                            </div>
                        </div>
                    </form>

                    <form class="form-horizontal" method="POST" action="{{ url('/post/delete') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{isset($post) ? $post->id : ''}}">
                        <button type="submit" class="btn btn-danger">
                            删除
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
