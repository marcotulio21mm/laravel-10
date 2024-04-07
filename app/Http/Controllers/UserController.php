<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index', [
            'users' => DB::table('users')->orderBy('name')->paginate('10'),
            'tittle' => 'Título retornado pelo controller',
            'randomUserInfo' => User::find(1),
        ]);
    }
}
