<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
    public function index() {

    $user = Auth::user();
    return view("Admin.dashboard-admin", ["user"=> $user]);
    }
}
