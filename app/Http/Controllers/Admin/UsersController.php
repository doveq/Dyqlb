<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Controller;

class UsersController extends Controller
{
    public function login() {
        return view('admin/login');
    }
}
