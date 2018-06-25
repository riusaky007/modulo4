<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use App\Services\SocialFacebookAccountService;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class SocialAuthFacebookController extends Controller
{
    private $firebase;

    public function __construct()
    {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/mycommute-891a4-firebase-adminsdk-qf24x-6c6b90aa3f.json');
        $this->firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri('https://mycommute-891a4.firebaseio.com/')
            ->create();
    }
    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Return a callback method from facebook api.
     *
     * @return callback URL from facebook
     */
    public function callback(SocialFacebookAccountService $service)
    {
        $user = $service->createOrGetUser(Socialite::driver('facebook')->user());
        //print_r($user);
        auth()->login($user);
        //return redirect()->to('/home');

        $database = $this->firebase->getDatabase();


        $newPost = $database
            ->getReference('erp/users')
            ->push([
                'id' => '' ,
                'nombre' => $user['name'] ,
                'email' => $user['email'],
                'marcabaja' => 0,
                'fecharegistro' => date("d-m-Y")
            ]);
        $reference = $database->getReference('erp/users/'.$newPost->getKey());
        $reference->update(['id'=>$newPost->getKey()]);


        return view('/home',compact('user'));
    }
}
