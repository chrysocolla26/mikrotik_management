<?php

namespace App\Http\Controllers;

use App\Department;
use App\User;
use App\VpnAclList;
use App\VpnUser;
use App\VpnUserGroup;
use Illuminate\Http\Request;
use PEAR2\Net\RouterOS;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Exception;
use GuzzleHttp\Client;
use DB;

class ClientDashboardController extends Controller
{
    public function dataVpnClient(Request $request){
        //// DAPETIN IP USER DARI NOMOR TIKET
        $UserId = User::where('email',$request->user_email)->value('id');
        $vpnUsername = VpnUser::where('user_id',$UserId)->value('vpn_username');
        $vpnAclTiket = VpnUser::where($vpnUsername)->pluck('no_ticket');
        // Bandingin hasil Array dari $vpnAclAllow dengan table no_ticket pake whereRaw
        $vpnAclAllow = VpnAclList::whereRaw('no_ticket',$vpnAclTiket)->pluck('address')->toArray();
    }

    public function loginEmailLDAPClient(Request $request){
        ////////////////////////////////////////LDAP
        // $ldap_dn = "CN=Mikrotik Management,OU=Vendor,OU=Data Center,OU=IT,DC=binus,DC=local";
        // $ldap_password ="M1cro-TEECH!!";
        $ldap_dn = $request->password_name."@binus.edu";
        $ldap_password = $request->password_pwd;
        
        $ldap_con = ldap_connect("10.200.200.201", 389);
        ldap_set_option($ldap_con, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap_con, LDAP_OPT_REFERRALS, 0);
        
        try {
            if(@ldap_bind($ldap_con, $ldap_dn, $ldap_password)) {

                // echo "Bind successful!";
                
                $filter = "(mail=".$request->password_name."@binus.edu)";
                // $filter = "(mail=aeffendi@binus.edu)";
                $result = ldap_search($ldap_con, "dc=binus,dc=local", $filter) or exit("Unable to search");
                $entries = ldap_get_entries($ldap_con, $result);
                // print "<pre>";
                // print_r ($entries);
                // print "</pre>";
                $user_name = $entries[0]["cn"][0];
                $user_email = $entries[0]["userprincipalname"][0];
                $user_department = $entries[0]["department"][0];
                // echo $user_name . " is on department of " . $user_department . ". Email: " . $user_email . "<br>";
    
                $manager_name = str_replace("CN=", "", $entries[0]["manager"][0]);
                $manager_name = substr($manager_name, 0, strpos($manager_name, ","));
    
                while(!strpos(ldap_get_entries($ldap_con, ldap_search($ldap_con, "dc=binus,dc=local", "(CN=".$manager_name.")"))[0]["title"][0], "Manager")){
                    // echo $manager_name . " is not Manager";
                    $filter = "(CN=".$manager_name.")";
                    $result = ldap_search($ldap_con, "dc=binus,dc=local", $filter) or exit("Unable to search");
                    $entries = ldap_get_entries($ldap_con, $result);
                    $manager_name = str_replace("CN=", "", $entries[0]["manager"][0]);
                    $manager_name = substr($manager_name, 0, strpos($manager_name, ","));
                    $manager_email = $entries[0]["userprincipalname"][0];
                    // echo  ". Email: " . $manager_email . "<br>";
                }
                // echo $manager_name . " is Manager";
                
                $filter = "(CN=".$manager_name.")";
                $result = ldap_search($ldap_con, "dc=binus,dc=local", $filter) or exit("Unable to search");
                $entries = ldap_get_entries($ldap_con, $result);
                $manager_email = $entries[0]["userprincipalname"][0];
                // echo  ". Email: " . $manager_email . "<br>";
    
                // print "<pre>";
                // print_r ($entries);
                // print "</pre>";
    
                // $data["ticket"] = $request->ticket;
                $data["user_name"] = $user_name;
                $data["user_email"] = $user_email;
                $data["user_department"] = $user_department;
                // $data["manager_name"] = $manager_name;
                // $data["manager_email"] = $manager_email;

                // $User = User::all();
                // $User->id = User::where('email',$request->user_email)->first()->id;

                // $VpnUser = VpnUser::all();
                // $vpn_username = VpnUser::where($User->user_id,$VpnUser->user_id)->first()->vpn_username;
                // // $no_ticket 
                // $vpnAclTiket = VpnUser::where($vpn_username)->first()->no_ticket;
                // dd($vpnAclTiket);
                //// DAPETIN USERNAME
                // $userName = User::where('email',$request->user_email)->value('id');

                //// DAPETIN IP USER DARI NOMOR TIKET
                $UserId = User::where('email',$request->user_email)->value('id');
                $vpnUsername = VpnUser::where('user_id',$UserId)->value('vpn_username');
                $vpnAclTiket = VpnUser::where($vpnUsername)->pluck('no_ticket');
                // Bandingin hasil Array dari $vpnAclAllow dengan table no_ticket pake whereRaw
                $vpnAclAllow = VpnAclList::whereRaw('no_ticket',$vpnAclTiket)->pluck('address')->toArray();


                return view('pages.client.dashboard')->with(['data'=> $data,'vpnUsername'=>$vpnUsername,'vpnAclAllow'=>$vpnAclAllow]);

                // return view('pages.client.login')->with('error', 'Invalid Email / Password!');
    
                /////////////////////////////API ITHELPDESK
                // $ch = curl_init();
    
                // curl_setopt($ch, CURLOPT_URL, "https://ithelpdesk.apps.binus.edu/api/v3/requests/64111"); //GET TICKET DETAIL
                // curl_setopt($ch, CURLOPT_URL, "https://ithelpdesk.apps.binus.edu/api/v3/requests"); // GET ALL TICKETS
                // $client = new Client([
                // 	'base_uri' => 'https://ithelpdesk.apps.binus.edu/api/v3/',
                // ]);
    
                // $response = $client->request('GET', 'requests/64536',[
                // 	'headers'=>[
                // 		'Content-Type' => 'application/x-www-form-urlencoded',
                // 		'Authtoken' => '3BB79015-7E6F-43BF-9EC9-8462F0DACE4C'
                // 	]
                // ]
                // 	'body'=>[
                // 		'input_data=' => ''
                // 	]
                // );
                // $body = json_decode($response->getBody());
                // dd($body);
                // print "<pre>";
                // print_r($name);
                // print_r ($body);
                // print "</pre>";
                // echo $data['request']['status']['name'];
                

            }
        } catch (Exception $e) {
            return back()->withErrors(['Invalid Email / Password!']);
        }
        
        // } else {
        //     return back()->withErrors('Why error? :(');
        // }
    }
}