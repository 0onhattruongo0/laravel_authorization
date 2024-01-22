<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $group_id = DB::table('groups')->insertGetId([
            'name' => 'Administrator',
            'user_id' => 0,
            'permissions' => '{"groups":["view","add","delete","edit","permission"]}',
            'created_at'=> date('Y-m-d H:i:s'),
            'updated_at'=> date('Y-m-d H:i:s'),
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        if($group_id>0){
            $userId = DB::table('users')->insertGetId([
                'name' => 'admin',
                'email'=> 'nhattruong.truongcong@gmail.com',
                'password' => Hash::make('123456'),
                'group_id' => $group_id,
                'user_id' => 0,
                'created_at'=> date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
            ]);
        }
        if($userId>0){
            for($i =1; $i<=5;$i++){
                DB::table('posts')->insertGetId([
                    'title' => 'Lorem Ipsum',
                    'content'=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam pretium nunc vel ante commodo, in elementum diam congue. Mauris molestie sapien vel nulla semper semper. Ut id tellus lacus. In eget purus id lacus laoreet maximus. Aliquam dictum eros at risus commodo gravida. Etiam porta, tellus eget interdum faucibus, orci tellus efficitur turpis, sagittis iaculis erat augue ut magna. Curabitur molestie viverra neque, tempor gravida magna hendrerit sit amet.',
                    'user_id' => $userId,
                    'created_at'=> date('Y-m-d H:i:s'),
                    'updated_at'=> date('Y-m-d H:i:s'),
                ]);
            }
        }


        DB::table('modules')->insert([
            'name' => 'users',
            'title'=> 'Quản lý người dùng',
            'created_at'=> date('Y-m-d H:i:s'),
            'updated_at'=> date('Y-m-d H:i:s'),
        ]);

        DB::table('modules')->insert([
            'name' => 'groups',
            'title'=> 'Quản lý nhóm',
            'created_at'=> date('Y-m-d H:i:s'),
            'updated_at'=> date('Y-m-d H:i:s'),
        ]);

        DB::table('modules')->insert([
            'name' => 'posts',
            'title'=> 'Quản lý bài viết',
            'created_at'=> date('Y-m-d H:i:s'),
            'updated_at'=> date('Y-m-d H:i:s'),
        ]);
    }
}
