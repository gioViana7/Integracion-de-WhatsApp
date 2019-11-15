<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CloudinaryController extends Controller
{
    public function signature(Request $request)
    {
        $params = json_decode($request->getContent(), true);
        return response()->json([
            'signature' => \Cloudinary::api_sign_request($params, config('services.cloudinary.api_secret')),
        ], 200);
    }
}
