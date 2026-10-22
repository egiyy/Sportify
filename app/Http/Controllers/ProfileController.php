<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function profile() {
        $data = [
            'nama' => 'Reggy Desvita Kamal',
            'npm' => '2417051016',
            'kelas' => 'B'
        ];
        return view('profile', $data);
    }
}