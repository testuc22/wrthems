<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\AuthRepository;

class AdminController extends Controller
{
	public function __construct(AuthRepository $authRepository)
    {
    	$this->middleware('auth:admin')->except(['getAdminLoginPage','doAdminLogin']);
        $this->authRepository=$authRepository;
    }

    public function getAdminLoginPage()
    {
        return view('admin/login');
    }

    public function doAdminLogin(Request $request)
    {
        $result=$this->authRepository->doLogin($guard='admin',$route='admin-dashboard',$request);
        return $result;
    }

    public function getAdminDashboard()
    {
        return view('admin/home');
    }

    public function doAdminLogout()
    {
        $result=$this->authRepository->doLogout($guard='admin',$route='admin-login');
        return $result;
    }
}
