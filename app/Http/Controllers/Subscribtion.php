<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Subscribers;
use Illuminate\Http\Request;
use Intervention\Image\Colors\Rgb\Channels\Red;
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
                return response()->json([
                    'status' => 'error',
                    'message' => 'Given email already subscribed.',
                ], 409);
            }

            //? insert the email into the database
            Subscribers::create([
                'email' => $request->email,
                'region' => $request->user_region ?? null,
                'city' => $request->user_city ?? null,
                'ip' => $request->user_ip ?? null,
                'country' => $request->user_country ?? null,
                'token' => bin2hex(random_bytes(36)),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Subscribed successfully.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred.',
            ], 500);
        }
    }


    public function unsubscribe(Request $request, string $token)
    {
        if (!$token) abort(404);

        //? check if token is valid and retrive the email
        $subsciber = Subscribers::where('token', $token)->first();

        if (!$subsciber) abort(404);

        //? retrieve the email from the database
        $email = $subsciber->email;

        return view('unsubscribe', compact('email', 'token'));
    }


    public function destroy(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'email' => 'required|email',
            'subscriber_token' => 'required|string',
        ]);

        //? check if the email exists in the database
        $exists = Subscribers::where('email', $request->email)
            ->where('token', $request->subscriber_token)
            ->exists();

        if (!$exists) {
            return back()->with('error', 'Email not found in the database.');
        }

        //? delete the email from the database
        Subscribers::where('email', $request->email)
            ->where('token', $request->subscriber_token)
            ->delete();

        return redirect()->route('unsubscribe.success')->with('success', 'Unsubscribed successfully.');
    }


    public function success()
    {
        return view('unsubscribe-success');
    }
}