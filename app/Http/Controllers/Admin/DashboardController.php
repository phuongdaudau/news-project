<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    private $pathViewController = 'admin.dashboard.';
    private $prefix = "dashboard";

    public function __construct()
    {
        view()->share('prefix', $this->prefix);
    }

    public function index()
    {
        return view($this->pathViewController . 'index');
    }
}
