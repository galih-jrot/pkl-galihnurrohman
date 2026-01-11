<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        return app(DashboardController::class)->index($request);
    }
}
