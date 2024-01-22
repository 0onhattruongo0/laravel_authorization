@extends('layouts.admin')
@section('title')
Nhóm người dùng
@endsection

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Nhóm người dùng</h1>
</div>
@if(session('msg'))
<div class="alert alert-success text-center">
   {{ session('msg') }} 
</div>
@endif
@if(session('error'))
<div class="alert alert-danger text-center">
   {{ session('error') }} 
</div>
@endif
@can('groups.add')
<p>
    <a href='{{route('admin.groups.add')}}' class='btn btn-primary'>Thêm mới</a>
</p>
@endcan
<table class='table table-bordered'>
    <thead>
        <tr>
            <th width='5%'>STT</th>
            <th>Tên</th>
            <th>Người đăng</th>
            {{-- @can('groups.permission') --}}
            <th width=15%>Phân quyền</th>
            {{-- @endcan --}}
            @can('groups.edit')
            <th width='5%'>Sửa</th>
            @endcan
            @can('groups.delete')
            <th width='5%'>Xóa</th>
            @endcan
        </tr>
    </thead>
    <tbody>
        @if($lists->count()>0)
        @foreach($lists as $key => $item)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{$item->name}}</td>
            <td>
                @if(!empty($item->postTo->name))
                {{$item->postTo->name}}
                @endif
            </td>
            @can('groups.permission')
            <td><a href="{{ route('admin.groups.permission' , $item) }}" class="btn btn-warning">Phân quyền</a></td>
            @endcan
            @can('groups.edit')
            <td>
                <a href='{{route('admin.groups.edit',$item)}}' class='btn btn-warning'>Sửa</a>
            </td>
            @endcan
            @can('groups.delete')
            <td>
                @if(Auth::user()->group->id != $item->id)
                <a onclick = 'return confirm("Bạn chắc chắn muốn xóa không?")' href='{{route('admin.groups.delete',$item)}}' class='btn btn-danger'>Xóa</a>
                @endif
            </td>
            @endcan
        </tr>
        @endforeach
        @endif
    </tbody>
</table>

@endsection