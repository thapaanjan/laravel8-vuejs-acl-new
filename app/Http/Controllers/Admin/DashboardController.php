<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin; 
use App\Models\Role;
use DB;
class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function getAdminCountChart() {
        return Role::select('name as role_name')
            ->withCount(['admins'])
            ->groupBy('name')
            ->orderBy('role_name', 'asc')
            ->get();    
    }
    

}
