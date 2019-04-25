@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">超级管理员设置</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                        <div class="container">
                            @foreach ($user as $val)
                                <h3 class="post-title">
                                    昵称：{{ $val->name }}
                                </h3>
                                <h5 class="post-describe">
                                    ID: {{ $val->id }}
                                </h5>
                                <h5 class="post-describe">
                                    @if($val->role == 0)
                                    角色: 超级管理员
                                        @else
                                        角色: 普通成员
                                    @endif
                                </h5>
                            @endforeach
{{--                            {{ $allPost->links() }}--}}
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
