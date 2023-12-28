<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index', [
            'users'=> DB::table('users')->orderBy('name')->paginate('10')
        ]);
    }
}
