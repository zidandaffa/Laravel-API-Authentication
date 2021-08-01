<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MasukController extends Controller
{    
    /**
     * login
     *
     * @param  mixed $request
     * @return void
     */
    public function masuk(Request $request)
    {
        //Di dalam method masuk/login, dibuat validasi untuk memastikan data yang dimasukkan udah sesuai
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        //Jika validasi tersebut tidak terpenuhi, maka akan mengembalikan sebuah error response.
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //Jika validasi di atas terpenuhi, maka akan melakukan pencarian data user berdasarkan email yang dimasukan.
        $user = User::where('email', $request->email)->first();

        //Jika data user di temukan, maka kita akan melaukan pencocokan data password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Duh Login Gagal!', //jika data email dan password tidak sesuai, maka akan mengembalikan JSON Duh login gagal
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Hore Berhasil Masuk!', //jika email dan password sesuai, maka akan menampilkan Hore Berhasil Masuk!
            'data'    => $user,
            'token'   => $user->createToken('authToken')->accessToken    
        ]);
    }
    
    /**
     * keluar
     *
     * @param  mixed $request
     * @return void
     */
    public function keluar(Request $request)
    {
        $removeToken = $request->user()->tokens()->delete();

        //Setelah token berhasil di hapus di dalam server, maka kita akan mengembalikan sebuah response success,
        if($removeToken) {
            return response()->json([
                'success' => true,
                'message' => 'Logout Success!',  
            ]);
        }
    }
}