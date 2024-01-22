<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Group;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function index(){

        $user_id = Auth::user()->id;
        if(Auth::user()->user_id == 0){
            $lists = User::all();
        }else{
        $lists = User::orderBy('created_at','desc')->where('user_id',$user_id)->get();
        }
        return view('admin.users.lists',compact('lists'));
    }

    public function add(){
        $groups = Group::all();
        return view('admin.users.add',compact('groups'));
    }
    public function postAdd(Request $request){
        $request->validate(
            [
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
                'group_id' => ['required', function($attribute,$value,$fail){
                    if($value == 0){
                        $fail('Vui lòng chọn nhóm');
                    }
                }]
            ],
            [
                'name.required' => 'Tên đăng nhập bắt buộc phải nhập',
                'name.string' => 'Kiểu dữ liệu không hợp lệ',
                'email.required' => 'Email bắt buộc phải nhập',
                'email.email' => 'Định dạng email ko hợp lệ',
                'email.unique' => 'Email đã tồn tại',
                'password.required' => 'Mật khẩu bắt buộc phải nhập',
                'password.string' => 'Kiểu dữ liệu không hợp lệ',
                'password.min' => 'Mật khẩu bắt buộc phải từ 6 ký tự',
                'group_id.required' => 'Vui lòng chọn nhóm'
            ]
        );

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->group_id = $request->group_id;
        $user->user_id = Auth::user()->id;
        $user->save();
        return redirect(route('admin.users.index'))->with('msg','Thêm người dùng thành công');
    }

    public function edit(User $user){
        $this->authorize('update', $user);
        $groups = Group::all();
        return view('admin.users.edit',compact('user', 'groups'));
    }

    public function postEdit(User $user, Request $request){
        $this->authorize('update', $user);
        $request->validate(
            [
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email,'.$user->id,
                // 'password' => 'required|string|min:6',
                'group_id' => ['required', function($attribute,$value,$fail){
                    if($value == 0){
                        $fail('Vui lòng chọn nhóm');
                    }
                }]
            ],
            [
                'name.required' => 'Tên đăng nhập bắt buộc phải nhập',
                'name.string' => 'Kiểu dữ liệu không hợp lệ',
                'email.required' => 'Email bắt buộc phải nhập',
                'email.email' => 'Định dạng email ko hợp lệ',
                'email.unique' => 'Email đã tồn tại',
                // 'password.required' => 'Mật khẩu bắt buộc phải nhập',
                // 'password.string' => 'Kiểu dữ liệu không hợp lệ',
                // 'password.min' => 'Mật khẩu bắt buộc phải từ 6 ký tự',
                'group_id.required' => 'Vui lòng chọn nhóm'
            ]
        );
        $user->name = $request->name;
        $user->email = $request->email;
        if($request->password){
            $user->password = Hash::make($request->password);
        }
        $user->group_id = $request->group_id;
        $user->save();
        return redirect(route('admin.users.index'))->with('msg','Cập nhật người dùng thành công');
    }

    public function delete(User $user){

        $this->authorize('delete', $user);
        $postsCount = $user->post()->count(); 
        if($postsCount == 0){
            if(Auth::user()->id != $user->id){
                User::destroy($user->id);
                return redirect(route('admin.users.index'))->with('msg','Xóa người dùng thành công');
            }
            return redirect(route('admin.users.index'))->with('err','Bạn không thể xóa người dùng này');
        }
        return redirect(route('admin.users.index'))->with('err','Có '.$postsCount.' bài đăng thuộc người này nên không thể xóa');
    }
}
