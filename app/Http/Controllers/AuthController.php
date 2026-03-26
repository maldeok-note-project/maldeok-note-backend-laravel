<?php

namespace App\Http\Controllers;

// import
use Illuminate\Http\Request;


// 継承
class AuthController extends Controller{

    // 
    public function register(Request $request){
        return response()->json([
            'message' => 'register ok',
            'data' => $request->all()
        ]);
    }
}