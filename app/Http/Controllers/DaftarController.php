<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DaftarController extends Controller
{    
    /**
     * daftar
     *
     * @param  mixed $request
     * @return void
     */
    public function daftar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required',                      //Nama gaboleh kosong
            'email'     => 'required|email|unique:users',   //Gaboleh kosong/Input gaboleh sama dengan data yang udah ada di dalam table users
            'password'  => 'required|min:8|confirmed'       //Gaboleh kosong/Input minimal 8 karakter/Input harus punya inputan lagi untuk konfirmasi data yang sama
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400); //Jika validasi di atas ga terpenuhi, maka akan mengembalikan response error 
        }                                                       //Response error ini sifatnya dinamis, jadi menampilkan pesan error sesuai dengan kondisi yang didapet.
        
        //Jika validasi di atas terpenuhi, maka akan melakukan insert data user baru ke dalam database
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password)
        ]);

        //kembalikan dalam bentuk format json
        return response()->json([
            'success' => true,
            'message' => 'Hore Pendaftaran Berhasil!',
            'data'    => $user  
        ]);
    }
}