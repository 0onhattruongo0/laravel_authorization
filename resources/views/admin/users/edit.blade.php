@extends('layouts.admin')
@section('title')
Cập nhật người dùng
@endsection

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Cập nhật người dùng</h1>
</div>
@if($errors->any())
<div class="alert alert-danger text-center">
    Đã có lỗi xảy ra vui lòng thử lại
</div>
@endif

<form action="" method="POST" class="">
@csrf
<div class='mb-3'>
    <label for="">Tên</label>
    <input type="text" name='name'  class="form-control @error('name') is-invalid @enderror" value="{{ old('name') ?? $user->name }}" placeholder = 'Tên...'>
    @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
<div class='mb-3'>
    <label for="">Email</label>
    <input type="email" name='email' class="form-control @error('email') is-invalid @enderror" value="{{ old('email') ?? $user->email }}" placeholder = 'Email...'>
    @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
<div class='mb-3'>
    <label for="">Mật khẩu (Không thay đổi thì không nhập)</label>
    <input type="password" name='password' class="form-control @error('password') is-invalid @enderror" placeholder = 'Mật khẩu...'>
    @error('password')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
<div class='mb-3'>
    <label for="">Nhóm</label>
    <select name="group_id" id="" class="form-control @error('group_id') is-invalid @enderror">
        <option value="0" class="" selected disabled>Chọn nhóm</option>
        @foreach($groups as $key => $item)
        <option value="{{$item->id}}" {{$user->group_id == $item->id || $item->id == old('group_id') ? 'selected' : false}} class="">{{$item->name}}</option>
        @endforeach
    </select>
    @error('group_id')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
<button class="btn btn-primary">Cập nhật</button>
</form>


@endsection