<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display the tenants admin page.
     */
    public function tenants()
    {
        return view('admin.tenants');
    }

    /**
     * Display the rooms admin page.
     */
    public function rooms()
    {
        return view('admin.rooms');
    }
}
