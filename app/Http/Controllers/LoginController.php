<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PEAR2\Net\RouterOS;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\redirect;

class LoginController extends Controller
{
    /*public function login(Request $request){
        try {
            // $client = new RouterOS\Client('10.21.0.234', 'admin', 'mikman123!');
            $client = new RouterOS\Client($request->address, $request->user, $request->password);

            $util = new RouterOS\Util($client);
            // $datas = $util->setMenu('/log')->getAll(); 
            // $datas = $client->sendSync(new RouterOS\Request('/ip address print'));

            return view('dashboard', compact('util'));
        } catch (Exception $e) {
            // return redirect()->back()->with('error',$e);
        }
    }*/

    public function login(Request $request){     
        // if(!Session::has('isLogin'))
            // return view('login');
        return view('dashboard');
    }

    public function loginpost(Request $request){
        // $validate = Validator::make(
        //     $request->all(), 
        //     ['ipaddress' => 'required|ip',
        //     'username' => 'required',
        //     'password' => 'required',
        //     ]
        // );

        // if($validate->fails()){
        //     return redirect()->back()->withInput($request->input)->withErrors($validate);
        // }else{
            try {
                // DO WHILE
                $client = new RouterOS\Client('10.21.0.234', 'admin', 'mikman123!');
                $util = new RouterOS\Util($client);
                // dd($client);
            }catch(Exception $e){
                echo "error g bisa ";
            }
            session::put('client',$client);
            session::put('util',$util);
            // return view('dashboard');
            return view('dashboard', compact('client'));
            // return redirect('/dashboard')->with(session::put('util',$util));
        // }
    }

    function logout(Request $request){
        $request->session()->flush();
        
        return redirect('');
     }

    function getIP(){
        // $client = session::get('client');
        // $util = $util = new RouterOS\Util($client);
        // $client = new RouterOS\Client('10.21.0.234');
        // session::put('client',$client);

        dd(session::get('client'));

        return view('ipall', compact('util'));
    }
}
