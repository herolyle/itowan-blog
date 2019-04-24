@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">全部博客</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                        <div class="container">
                            @foreach ($allPost as $post)
                                <h2 class="post-title">
                                    <a href="#">{{ $post->title }}</a>
                                </h2>
                                <h5 class="post-describe">
                                    简介：{{ $post->describe }}
                                </h5>
                                <h4>
                                    内容：{{ $post->content }}
                                </h4>
                            @endforeach
                            {{ $allPost->links() }}
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
