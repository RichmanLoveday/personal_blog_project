<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Subscribers;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Subscribtion extends Controller
{
    public function store(Request $request)
    {
        // dd($request->user_region, $request->user_city, $request->user_ip, $request->user_country);
        try {
            $request->validate([
                'email' => 'required|email',
            ]);

            //? check if the email already exists in the database
            $exists = Subscribers::where('email', $request->email)->exists();

            if ($exists) {
                throw new HttpException(409, 'Email already exists in the database.');
            }

            //? insert the email into the database
            Subscribers::create([
                'email' => $request->email,
                'region' => $request->user_region,
                'city' => $request->user_city,
                'ip' => $request->user_ip,
                'country' => $request->user_country,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Subscribed successfully.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ],  500);
        }
    }

    public function delete() {}
}