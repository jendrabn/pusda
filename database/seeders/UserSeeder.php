<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $users = collect(json_decode(Storage::get('seeds/pusda_lama.json'), true));
        $users = collect($users->where('type', 'table')->where('name', 'users')->first()['data']);
        User::insert($users->map(function ($user) {
            return [
                'id' => $user['id'],
                'skpd_id' => $user['id_skpd'],
                'name' => $user['name'],
                'username' => $user['username'],
                'email' => $user['email'],
                'no_hp' => $user['no_hp'],
                'alamat' => $user['alamat'],
                'level' => $user['level'],
                'password' => $user['password'],
                'created_at' => $user['created_at'],
                'updated_at' => $user['updated_at']
            ];
        })->toArray());

        // $users = collect(json_decode(Storage::get('seeds/pusda_baru.json'), true));
        // $users = $users->where('type', 'table')->where('name', 'users')->first()['data'];
        // User::insert($users);
    }
}
