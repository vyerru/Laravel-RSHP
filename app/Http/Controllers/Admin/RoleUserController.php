<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoleUser;
use Illuminate\Http\Request;

class RoleUserController extends Controller
{
    public function index() {
        $roleUser = RoleUser::with('user', 'role')->get(); 
        return view('Admin.RoleUser.index', compact('roleUser'));
    }
}
