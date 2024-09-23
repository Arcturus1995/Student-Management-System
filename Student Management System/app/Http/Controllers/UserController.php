<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(){
        return 'Hello World';
    }
    public function show($id){

        // $data = array(
        //     "id" => $id,
        //     "name" => "Hero Alamsyah",
        //     "email"=> "junjun@gmail.com",
        //     "age"=> 22
        // );

        // $data =["data" => "Data from database"];
        // return view('user')
        //     ->with('data',$data)
        //     ->with('name', 'Hero Alamsyah')
        //     ->with('age', 22)
        //     ->with('email', 'Hero@gmail.com')
        //     ->with('id', $id);
    }
    public function login(){
        if(View::exists('users.login')){
            return view('users.login');
        }else{
            // return response()->view('errors.404');
            return abort('404');
        }

    }  
    public function process(Request $request){
        // Validate the incoming request data
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required',
        ]);
    
        // Attempt to authenticate the user
        if(Auth::attempt($validated)){
            $request->session()->regenerate();
            return redirect('/')->with('message','Welcome back!');
        }
        return back()->withErrors(['email' => 'Log in failed']) -> onlyInput('email');
    }
    
    public function register(){
        return view('users.register');
    }
    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'name' => ['required', 'min:4'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'confirmed', 'min:6']
        ]);
    
        // Hash the password before creating the user
        $validated['password'] = bcrypt($validated['password']);
    
        // Create the user with the validated data
        $user = User::create($validated);
    
        // Log in the user using the default guard
        Auth::login($user);
    
        // Redirect to a specified route with a success message
        return redirect('/register')->with('message', 'Registration successful');
    }
    

    public function logout(Request $request){
        auth('')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('message','Logout Successful');
    }

}