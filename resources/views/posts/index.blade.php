@extends('layouts.layout')

@section('content')
    @if(isset($_GET['search']))
        @if(count($posts)>0)
            <h3>Результаты поиска по запросу "{{$_GET['search']}}"</h3>
            @if(count($posts)>4)
                <p>Найдено всего {{count($posts)}} постов</p>
                @elseif(count($posts)==1) <p>Найден всего {{count($posts)}} пост</p>
            @else
                <p>Найдено всего {{count($posts)}} поста</p>
            @endif
        @else
            <h2>По запросу "{{htmlspecialchars($_GET['search'])}}"ничего не найдено</h2>
            <a href="{{ route('post.index') }}" class="btn btn-outline-primary">Посмотреть все посты</a>
        @endif
    @endif
    <div class="row">
        @foreach($posts as $post)
        <div class="col-6">
            <div class="card">
                <div class="card-header"><h2>{{$post->short_title}}</h2></div>
                <div class="card-body">
                    <div class="card-img" style="background-image: url({{ $post->img ?? asset('img/default.jpg') }})"></div>
                    <div class="card-author">Автор: {{ $post->name }}</div>
                    <a href="{{ route('post.show',['id'=>$post->post_id]) }}" class="btn btn-outline-primary">Посмотреть пост</a>
                </div>

            </div>
        </div>
        @endforeach
    </div>

    @if(!isset($_GET['search']))
    {{$posts->links()}}
    @endif
@endsection
