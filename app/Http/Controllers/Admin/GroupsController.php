<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;

class GroupsController extends Controller
{
    public function index()
    {

        $user_id = Auth::user()->id;
        if (Auth::user()->user_id == 0) {
            $lists = Group::all();
        } else {
            $lists = Group::orderBy('created_at', 'desc')->where('user_id', $user_id)->get();
        }
        return view('admin.groups.lists', compact('lists'));
    }

    public function add()
    {
        return view('admin.groups.add');
    }

    public function postAdd(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|unique:groups,name',
            ],
            [
                'name.required' => 'Tên nhóm bắt buộc phải nhập',
                'name.unique' => 'Tên nhóm đã tồn tại',
            ]
        );

        $group = new Group;
        $group->name = $request->name;
        $group->user_id = Auth::user()->id;
        $group->save();
        return redirect(route('admin.groups.index'))->with('msg', 'Thêm nhóm thành công');
    }

    public function edit(Group $group)
    {
        $this->authorize('update', $group);
        return view('admin.groups.edit', compact('group'));
    }

    public function postEdit(Group $group, Request $request)
    {
        $this->authorize('update', $group);
        $request->validate(
            [
                'name' => 'required|unique:groups,name,' . $group->id,
            ],
            [
                'name.required' => 'Tên nhóm bắt buộc phải nhập',
                'name.unique' => 'Tên nhóm đã tồn tại',
            ]
        );
        $group->name = $request->name;
        $group->user_id = Auth::user()->id;
        $group->save();
        return redirect(route('admin.groups.index'))->with('msg', 'Cập nhật thành công');
    }

    public function delete(Group $group)
    {
        $this->authorize('delete', $group);
        $usersCount = $group->user()->count();
        if ($usersCount == 0) {
            if (Auth::user()->group->id != $group->id) {
                Group::destroy($group->id);
                return redirect(route('admin.groups.index'))->with('msg', 'Xóa nhóm thành công');
            }
            return redirect(route('admin.groups.index'))->with('error', 'Bạn không thể xóa nhóm này');
        }

        return redirect(route('admin.groups.index'))->with('error', 'Trong nhóm vẫn còn ' . $usersCount . ' người dùng');
    }

    public function permission(Group $group)
    {
        $this->authorize('permission', $group);
        $modules = Module::all();
        $roleListArr = [
            'view' => 'Xem',
            'add' => 'Thêm',
            'edit' => 'Sửa',
            'delete' => 'Xóa'
        ];

        $roleJson = $group->permissions;

        if (!empty($roleJson)) {
            $roleArr = json_decode($roleJson, true);
        } else {
            $roleArr = [];
        }
        // dd($roleArr);
        return view('admin.groups.permission', compact('group', 'modules', 'roleListArr', 'roleArr'));
    }

    public function postPermission(Group $group, Request $request)
    {
        $this->authorize('permission', $group);
        if (!empty($request->role)) {
            $roleList = $request->role;
        } else {
            $roleList = [];
        }

        $roleListJson = json_encode($roleList);
        $group->permissions = $roleListJson;
        $group->save();
        return back()->with('msg', 'Phân quyền thành công');
    }
}
