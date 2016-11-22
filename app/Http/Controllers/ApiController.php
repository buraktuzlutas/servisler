<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Input;
use Hash;

class ApiController extends Controller
{
    public function login()
    {
        $user = User::where('email', Input::get('email'))->first();
        if (Hash::check(Input::get('password'), $user->password)) {
            return response()->json([
                'case' => '1',
                'token' => md5(Input::get('email') . Input::get('password'))
            ]);
        } else
            return response()->json([
                'case' => '0',
                'mesaj' => 'hatali giris'
            ]);

    }

    public function register()
    {
        if (User::where('email', Input::get('email'))->first())
            return response()->json([
                'case' => '0',
                'mesaj' => 'uye kayitlidir'
            ]);
        else {
            $user = new User();
            $user->name = Input::get('name');
            $user->surname = Input::get('surname');
            $user->email = Input::get('email');
            $user->password = bcrypt(Input::get('password'));
            $user->phone_number = Input::get('phone_number');
            $user->setRememberToken(md5(Input::get('email') . Input::get('password')));
            $user->save();
            return response()->json([
                'case' => '1',
                'mesaj' => 'uye kayit basarili',
                'token' => $user->getRememberToken()
            ]);
        }

        /*$uye = Uyeler::where('email', Input::get('email')->first());
        return 'ds';
        return Uyeler::where('adi', 'asd')->first();*/
    }
}
