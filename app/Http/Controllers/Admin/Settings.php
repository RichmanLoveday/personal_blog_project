<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class Settings extends Controller
{
    public function index()
    {
        $settings = Setting::first();
        // dd($settings->toArray());

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        //dd($request->all());

        try {

            $request->validate([
                'phone' => 'nullable|integer',
                'facebook_link' => 'nullable|url',
                'youtube_link' => 'nullable|url',
                'twitter_link' => 'nullable|url',
                'email_link' => 'nullable|email',
                'our_mission' => 'nullable|string',
                'our_vission' => 'nullable|string',
                'our_best_services' => 'nullable|string',
                'address' => 'nullable|string',
            ]);

            //? update site settings
            Setting::updateOrCreate(
                ['id' => 1], // Assuming there's a single settings row with ID 1
                [
                    'phone' => $request->phone,
                    'facebook_link' => $request->facebook_link,
                    'youtube_link' => $request->youtube_link,
                    'twitter_link' => $request->twitter_link,
                    'email_link' => $request->email_link,
                    'our_mission' => $request->our_mission,
                    'our_vission' => $request->our_vission,
                    'our_best_services' => $request->our_best_services,
                    'address' => $request->address
                ]
            );

            //? return response
            return response()->json([
                'status' => 'success',
                'message' => 'Site settings updated successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error updating site setting: ' . $e->getMessage(),
            ], 500);
        }
    }
}