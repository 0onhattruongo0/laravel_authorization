@extends('layouts.admin')
@section('title')
Phân quyền
@endsection

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Phân quyền nhóm: {{ $group->name }}</h1>
</div>
@if(session('msg'))
<div class="alert alert-success text-center">
   {{ session('msg') }} 
</div>
@endif
<form action="" method="POST">
    <table class='table table-bordered'>
        <thead>
            <tr>
                <th width='20%'>Modules</th>
                <th>Quyền</th>
            </tr>
        </thead>
        <tbody>
            @if($modules->count() >0)
            @foreach($modules as $key => $item)
            <tr>
                <td>{{ $item->title }}</td>
                <td>
                    <div class="row">
    
                        @if(!empty($roleListArr))
                        @foreach($roleListArr as $roleName => $roleLabel)
                            <div class="col-2">
                                <label for="role_{{$item->name}}_{{$roleName}}">
                                    <input type="checkbox" name='role[{{$item->name}}][]' id='role_{{$item->name}}_{{$roleName}}'
                                    {{isRole($roleArr,$item->name,$roleName) ? 'checked' : false}}
                                    value='{{$roleName}}'>
                                    {{$roleLabel}}
                                </label>
                            </div>
                        @endforeach
                        @endif
                
                        @if($item->name == 'groups')
                        <div class="col-2">
                            <label for="role_{{$item->name}}_pemission">
                                <input type="checkbox" name='role[{{$item->name}}][]' id='role_{{$item->name}}_pemission'
                                {{isRole($roleArr,$item->name,'permission') ? 'checked' : false}}
                                value='permission'>
                                Phân quyền
                            </label>
                        </div>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
    @csrf
    <button type='submit' class="btn btn-primary">Phân quyền</button>
</form>


@endsection