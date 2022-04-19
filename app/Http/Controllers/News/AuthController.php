<?php

namespace App\Http\Controllers\News;

use App\Models\UserModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AuthLoginRequest as MainRequest;

class AuthController extends Controller
{
    private $pathViewController = 'news.pages.auth.';
    private $prefix = "auth";

    public function __construct()
    {
        view()->share('prefix', $this->prefix);
    }

    public function login(Request $request)
    {
        return view($this->pathViewController . 'login', []);
    }
    public function register(Request $request)
    {
        return view($this->pathViewController . 'register', []);
    }

    public function postLogin(MainRequest $request)
    {
        if ($request->method() == 'POST') {
            $params = $request->all();
            $userModel = new UserModel();
            $userInfo = $userModel->getItem($params, ['task' => 'auth-login']);

            if (!$userInfo)
                return redirect()->route($this->prefix . '/login')->with('Notify',  'Thông tin email hoặc mật khẩu không chính xác!');

            $request->session()->put('userInfo', $userInfo);
            return redirect()->route('home');
        }
    }
    public function postRegister(MainRequest $request)
    {
        echo "123";
        if ($request->method() == 'POST') {
            $params = $request->all();
            $userModel = new UserModel();
            $userModel->saveItems($params, ['task' => 'register-account']);

            return redirect()->route($this->prefix . '/login')->with('Notify',  'Mời bạn đăng nhập tài khoản!');
        }
    }

    public function logout(Request $request)
    {
        if ($request->session()->has('userInfo'))  $request->session()->pull('userInfo');
        return redirect()->route('home');
    }
}

/* echo '<pre style="color:red">';
        print_r($itemCategory);
        echo '</pre>'; */