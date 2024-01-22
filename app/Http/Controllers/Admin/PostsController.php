<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    public function index(){

        $user_id = Auth::user()->id;
        if(Auth::user()->user_id == 0){
            $lists = Post::all();
        }else{
        $lists = Post::orderBy('created_at','desc')->where('user_id',$user_id)->get();
        }
        return view('admin.posts.lists',compact('lists'));
    }

    public function add(){
        return view('admin.posts.add');
    }

    public function postAdd(Request $request){
        $request->validate(
            [
                'title' => 'required',
                'content' => 'required',
            ],
            [
                'title.required' => 'Tiêu đề bắt buộc phải nhập',
                'content.required' => 'Nội dung bắt buộc phải nhập',
            ]
        );
        $post = new Post;
        $post->title = $request->title;
        $post->content = $request->content;
        $post-> user_id = Auth::user()->id;
        $post->save();
        return redirect(route('admin.posts.index'))->with('msg','Thêm bài viết thành công');
    }

    public function edit(Post $post){
        $this->authorize('update', $post);
        return view('admin.posts.edit', compact('post'));
    }

    public function postEdit(Post $post,Request $request){
        $this->authorize('update', $post);
        $request->validate(
            [
                'title' => 'required',
                'content' => 'required',
            ],
            [
                'title.required' => 'Tiêu đề bắt buộc phải nhập',
                'content.required' => 'Nội dung bắt buộc phải nhập',
            ]
        );
        $post->title = $request->title;
        $post->content = $request->content;
        $post->save();
        return redirect(route('admin.posts.index'))->with('msg','Cập nhật bài viết thành công');
    }

    public function delete(Post $post){
            $this->authorize('delete', $post);
            Post::destroy($post->id);
            return redirect(route('admin.posts.index'))->with('msg','Xóa bài viết thành công');
    }
}
