@extends('layouts.admin')
@section('title')
Danh sách bài viết
@endsection

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Danh sách bài viết</h1>
</div>
@if(session('msg'))
<div class="alert alert-success text-center">
   {{ session('msg') }} 
</div>
@endif
@can('posts.add')
<p>
    <a href='{{route('admin.posts.add')}}' class='btn btn-primary'>Thêm mới</a>
</p>
@endcan
<table class='table table-bordered'>
    <thead>
        <tr>
            <th width='5%'>STT</th>
            <th>Tiêu đề</th>
            <th>Người đăng</th>
            @can('posts.edit')
            <th width='5%'>Sửa</th>
            @endcan
            @can('posts.delete')
            <th width='5%'>Xóa</th>
            @endcan
        </tr>
    </thead>
    <tbody>
        @if($lists->count()>0)
        @foreach($lists as $key => $item)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{$item->title}}</td>
            <td>{{$item->postBy->name}}</td>
            @can('posts.edit')
            <td>
                <a href='{{route('admin.posts.edit',$item)}}' class='btn btn-warning'>Sửa</a>
            </td>
            @endcan
            @can('posts.delete')
            <td>
                <a onclick = 'return confirm("Bạn chắc chắn muốn xóa không?")' href='{{route('admin.posts.delete',$item)}}' class='btn btn-danger'>Xóa</a>
            </td>
            @endcan
        </tr>
        @endforeach
        @endif
    </tbody>
</table>

@endsection