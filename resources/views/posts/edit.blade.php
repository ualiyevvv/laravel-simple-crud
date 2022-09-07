@extends('layouts.layout')
@section('content')
<form action="{{route('post.update',['id'=>$post->post_id])}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method("PATCH")
    <h3>Создать пост</h3>
    @include('layouts.forms.forms ')
    <input type="submit" class="btn btn-outline-success" value="Сохранить">
    <a class="btn btn-outline-primary" href="{{route('post.show',['id'=>$post->post_id])}}">Отменить</a>
</form>
@endsection
