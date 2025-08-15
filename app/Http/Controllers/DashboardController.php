<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function adminDashboard(){
        return view("dashboard");
    }
    public function userDashhboard(){
        return view("dashboard");
    }
}