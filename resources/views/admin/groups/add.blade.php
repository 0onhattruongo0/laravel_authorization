@extends('layouts.admin')
@section('title')
Thêm nhóm
@endsection

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Thêm nhóm</h1>
</div>
@if($errors->any())
<div class="alert alert-danger text-center">
    Đã có lỗi xảy ra vui lòng thử lại
</div>
@endif

<form action="{{route('admin.groups.postAdd')}}" method="POST" class="">
@csrf
<div class='mb-3'>
    <label for="">Tên nhóm</label>
    <input type="text" name='name'  class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder = 'Tên nhóm...'>
    @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
<button class="btn btn-primary">Thêm mới</button>
</form>


@endsection