<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use App\Model\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth')->except('index','show');
    }


    public function index(Request $request)
    {
        if($request->search){
            $posts = Post::join('users','author_id','=','users.id')
                ->where('title','like','%'.$request->search.'%')
                ->orWhere('descr','like','%'.$request->search.'%')
                ->orWhere('name','like','%'.$request->search.'%')
                ->orderBy('posts.created_at','desc')
                ->get();
            return view('posts.index',compact('posts'));
        }
        $posts = Post::join('users','author_id','=','users.id')
            ->orderBy('posts.created_at','desc')
            ->paginate(4);
        return view('posts.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $post = new Post();
        $post -> title = $request->title;
        $post ->short_title = Str::length($request->title)>30 ? Str::substr($request->title,0,30) . '...' : $request->title;
        $post -> descr = $request->descr;
        $post -> author_id = \Auth::user()->id;
        $post->created_at = Carbon::now();

        if($request->file('img')){
            $path = $request->file('img')->store('uploads','public');
//            $path = Storage::putFile('uploads',$request->file('img'));

            $url = Storage::url($path);
            $post -> img = $url;
        }
//        dd($_FILES);
        $post->save();
        return redirect()->route('post.index')->with('success','The post has been created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::join('users','author_id','=','users.id')
            ->select('post_id','title','descr','short_title','posts.created_at','author_id','img','users.name')
            ->find($id);
        if(!$post){
            return  redirect()->route('post.index')->withErrors('Вы куда-то не туда');
        }
//        $test = dd($post);
        return view('posts.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        if(!$post){
            return  redirect()->route('post.index')->withErrors('Вы куда-то не туда');
        }
        if($post->author_id !== \Auth::user()->id){
            return  redirect()->route('post.index')->withErrors('Вы не можете редактировать данный пост');
        }

        return view('posts.edit',compact('post'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
        $post = Post::find($id);

        if(!$post){
            return  redirect()->route('post.index')->withErrors('Вы куда-то не туда');
        }
        if($post->author_id !== \Auth::user()->id){
            return  redirect()->route('post.index')->withErrors('Вы не можете редактировать данный пост');
        }


        $post -> title = $request->title;
        $post ->short_title = Str::length($request->title)>30 ? Str::substr($request->title,0,30) . '...' : $request->title;
        $post -> descr = $request->descr;
        $post->updated_at = Carbon::now();

        if($request->file('img')){
            $path = $request->file('img')->store('uploads','public');
//            $path = Storage::putFile('uploads',$request->file('img'));

            $url = Storage::url($path);
            $post -> img = $url;
        }
//        dd($_FILES);
        $post->update();
        $id = $post->post_id;
        return redirect()->route('post.show',['id'=>$id])->with('success','Пост успешно отредактирован');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        if(!$post){
            return  redirect()->route('post.index')->withErrors('Вы куда-то не туда');
        }
        if($post->author_id !== \Auth::user()->id){
            return  redirect()->route('post.index')->withErrors('Вы не можете удалить данный пост');
        }

        $post->delete();
        return redirect()->route('post.index')->with('success','Пост успешно удален');
    }

    public function toBack(){
        return redirect()->back();
    }
}
