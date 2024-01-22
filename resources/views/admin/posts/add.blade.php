@extends('layouts.admin')
@section('title')
Thêm bài viết
@endsection

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Thêm bài viết</h1>
</div>
@if($errors->any())
<div class="alert alert-danger text-center">
    Đã có lỗi xảy ra vui lòng thử lại
</div>
@endif

<form action="{{route('admin.posts.postAdd')}}" method="POST" class="">
@csrf
<div class='mb-3'>
    <label for="">Tiêu đề</label>
    <input type="text" name='title'  class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder = 'Tiêu đề...'>
    @error('title')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
<div class='mb-3'>
    <label for="">Nội dung</label>
    <textarea name="content" id="" cols="30" rows="10" placeholder = 'Nội dung...' class="form-control  @error('content') is-invalid @enderror">{{old('content')}}</textarea>
    @error('content')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
<button class="btn btn-primary">Thêm mới</button>
</form>


@endsection