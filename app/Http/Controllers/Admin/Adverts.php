<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdvertsRequest;
use App\Models\Advert;
use App\Models\AdvertPlacement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Adverts extends Controller
{
    public function index()
    {
        return view('admin.advert.index');
    }

    public function create()
    {
        return view('admin.advert.create');
    }


    public function store(StoreAdvertsRequest $request)
    {
        dd($request->validated());
        try {
            DB::beginTransaction();
            $advert = Advert::create([
                'user_id' => Auth::user()->id,
                'title' => $request->title,
                'url' => $request->url,
                'startDate' => $request->startDate,
                'endDate' => $request->endDate,
            ]);

            $placementsDatas = [];

            //? loop through placements
            foreach ($request->placements as $placement) {
                //? store image in public/uploads/advert_images
                $imagePath = $this->uploadImage($placement);

                //? strore values in avert placement class for save many
                $placementsDatas[] = new AdvertPlacement([
                    'advert_id' => $advert->id,
                    'position' => $placement['position'],
                    'page' => $placement['page'],
                    'image' => $imagePath,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $advert->placements()->saveMany($placementsDatas);

            DB::commit();
            return response()->json(
                ['success' => 'Advert created successfully!'],
                200
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(
                ['error' => 'Error creating advert: ' . $e->getMessage()],
                500
            );
        }
    }

    public function edit($id) {}


    private function uploadImage(array $placement, string|int|null $advertPlacmentId = null): string
    {
        try {
            $directory = public_path('uploads/advert_images');

            //? Ensure the directory exists or create it
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            //? If an article ID is provided, delete the existing image
            if (!is_null($advertPlacmentId)) {
                $advertPlacement = AdvertPlacement::find($advertPlacmentId);
                if ($advertPlacement && $advertPlacement->image) {
                    File::delete(public_path($advertPlacement->image));
                }
            }

            //? Handle the uploaded file
            if (isset($placement['image']) && $placement['image']->isValid()) {
                $file = $placement['image'];
                $fileName = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                $file->move($directory, $fileName);

                return "uploads/advert_images/$fileName";
            }

            throw new \Exception('Invalid image file provided.');
        } catch (\Exception $e) {
            throw new \Exception('Error uploading image: ' . $e->getMessage());
        }
    }
}