<?php 
namespace App\Repositories;
use Illuminate\Http\Request;
use App\Models\{
	Admin
};
use Auth;
class AuthRepository
{
    public function doLogin($guard,$route,$request)
    {
        $request->validate([
    		'email'=>'required|email',
    		'password'=>'required'
    	]);
    	$credentials = $request->only('email', 'password');
        if (Auth::guard($guard)->attempt($credentials)) {
        	return redirect()->route($route);
        }
        else {
        	return redirect()->back()->with('message','Credentials Do not match');
        }
    }

    public function doLogout($guard,$route)
    {
        Auth::guard($guard)->logout();
        return redirect()->route($route);
    }
}

?>