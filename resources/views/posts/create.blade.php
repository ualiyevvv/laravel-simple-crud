@extends('layouts.layout')
@section('content')
<form action="{{route('post.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <h3>Создать пост</h3>
    @include('layouts.forms.forms ')
    <input type="submit" class="btn btn-outline-success">
    <a class="btn btn-outline-danger" href="{{route('post.index')}}">Отменить</a>
</form>
@endsection
