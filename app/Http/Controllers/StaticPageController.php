<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    public function home(){
        $users = User::count();
        return view('static.home', compact(['users']));
    }
}
