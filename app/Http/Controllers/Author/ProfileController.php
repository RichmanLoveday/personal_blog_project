<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index(string|int $id)
    {
        $author = User::where('id', $id)
            ->where('email', Auth::user()->email)
            ->first();

        //? if user is not found, abort
        if (!$author) {
            abort(404);
        }

        // dd($author);
        return view('author.profile.index', compact('author'));
    }


    public function update(Request $request)
    {
        // dd($request);
        //? validate inputs
        $request->validate([
            'firstName' => ['required', 'string', 'max:50'],
            'lastName' => ['required', 'string', 'max:50'],
            'aboutMe' => ['required', 'string', 'max:2500'],
            'phone' => ['required', 'regex:/^\+?[0-9]{10,15}$/'],
        ]);


        try {
            //? update user model
            User::where('id', Auth::user()->id)
                ->update([
                    'firstName' => $request->firstName,
                    'lastName' => $request->lastName,
                    'aboutMe' => $request->aboutMe,
                    'phone' => $request->phone,
                    'updated_at' => now(),
                ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Profile updated successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong!'
            ], 500);
        }
    }


    public function changePassword(ChangePasswordRequest $request)
    {
        //  dd($request->all());
        try {
            User::where('id', Auth::user()->id)
                ->update([
                    'password' => Hash::make($request->password),
                    'updated_at' => now(),
                ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Password successfully changed'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong!'
            ], 500);
        }
    }


    public function updateProfilePhoto(Request $request)
    {
        //dd($request->all());
        //? validate photo
        $request->validate([
            'photo' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048']
        ]);

        try {
            $directory = public_path('uploads/profile_photos');

            //? check if directory is exist, else create dir
            if (!File::exists($directory)) File::makeDirectory($directory, 0755, true, true);

            //? delete old photo
            if (Auth::user()->photo) File::delete(Auth::user()->photo);

            //? store new photo in file path
            $file = $request->file('photo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/profile_photos/'), $fileName);

            //? upload photo in user model
            User::where('id', Auth::user()->id)
                ->update([
                    'photo' => "uploads/profile_photos/$fileName",
                    'updated_at' => now()
                ]);

            //? return response 
            return response()->json([
                'status' => 'success',
                'message' => 'Profile photo uploaded successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong!'
            ], 500);
        }
    }
}
