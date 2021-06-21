<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function getUsers() {
        try {
            $selectedName = request('name');
            $users = User::orderBy('id', 'asc')
                // ->when($selectedName, function($query) use($selectedName){
                //     $query->where('name', 'like', '%' .$selectedName. '%');
                // })
                ->paginate(5);
            return response()->json($users);
        } catch (\Illuminate\Database\QueryException $e) {
            $e = "Get roles Api Error";
            return response()->json($e);
        }
    }
}
