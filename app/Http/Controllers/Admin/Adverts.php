<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdvertsRequest;
use App\Http\Requests\StoreUpdateAdvertsRequest;
use App\Models\Advert;
use App\Models\AdvertPlacement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Adverts extends Controller
{
    public function index()
    {
        //? get all adverts created
        $adverts = Advert::with(['user', 'placements'])
            ->latest()
            ->paginate(10)
            ->appends(request()->query());

        // dd($adverts);

        return view('admin.advert.index', compact('adverts'));
    }

    public function create()
    {
        return view('admin.advert.create');
    }

    public function store(StoreAdvertsRequest $request)
    {
        //  dd($request->validated());
        try {
            DB::beginTransaction();
            $advert = Advert::create([
                'user_id' => Auth::user()->id,
                'title' => $request->title,
                'url' => $request->url,
                'start_date' => Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d'),
                'end_date' => Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d'),
                'status' => 'active',
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
            //? redirect to index page with success message
            session()->flash('success', 'Advert created successfully!');

            //? return json response
            return response()->json(
                [
                    'status' => 'success',
                    'success' => 'Advert created successfully!',
                    'redirect_url' => route('admin.advert.index'),
                ],
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

    public function edit(int $id)
    {
        //? find advert by id
        $advert = Advert::with(['user', 'placements'])->findOrFail($id);
        // dd($advert->toArray());

        //? return view with advert data
        return view('admin.advert.edit', compact('advert'));
    }

    public function update(StoreAdvertsRequest $request)
    {
        try {
            //? begin transaction
            DB::beginTransaction();

            //? find advert by id
            $advert = Advert::findOrFail($request->id);

            //? update advert data
            $advert->update([
                'title' => $request->title,
                'url' => $request->url,
                'start_date' => Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d'),
                'end_date' => Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d'),
                'updated_at' => now(),
            ]);

            //? loop through placements
            foreach ($request->placements as $placement) {
                if (isset($placement['id'])) {
                    //? update existing placement
                    $existingPlacement = AdvertPlacement::findOrFail($placement['id']);

                    //? if image is set, delete the old image and upload new one
                    if (isset($placement['image'])) {
                        $placement['image'] = $this->uploadImage($placement, $existingPlacement->id);
                    }

                    //? update placement data
                    $existingPlacement->update([
                        'position' => $placement['position'],
                        'page' => $placement['page'],
                        'image' => $placement['image'] ?? $existingPlacement->image,
                    ]);
                } else {
                    //? create new placement
                    $imagePath = $this->uploadImage($placement);
                    AdvertPlacement::create([
                        'advert_id' => $advert->id,
                        'position' => $placement['position'],
                        'page' => $placement['page'],
                        'image' => $imagePath,
                    ]);
                }
            }

            //? commit the transaction
            DB::commit();
            session()->flash('success', 'Advert updated successfully!');

            return response()->json(
                [
                    'status' => 'success',
                    'success' => 'Advert updated successfully!',
                    'redirect_url' => route('admin.advert.index'),
                ],
                200
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(
                ['error' => 'Error updating advert: ' . $e->getMessage()],
                500
            );
        }
    }


    public function updateStatus(Request $request)
    {
        //dd($request->all());
        //? update advert status
        try {
            //? validate request
            $request->validate([
                'id' => 'required|integer|exists:adverts,id',
                'status' => 'required|string|in:active,in-active',
            ]);

            //? find advert by id or fail
            $advert = Advert::findOrFail($request->id);

            //? update status
            $advert->update([
                'status' => $request->status,
            ]);

            return response()->json(['status' => 'success', 'message' => 'Advert status updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Error updating advert status: ' . $e->getMessage()], 500);
        }
    }

    public function deletePlacement(int $id)
    {
        // dd($id);
        //? delete advert placement
        try {
            //? find placement by id or fail
            $placement = AdvertPlacement::findOrFail($id);

            //? delete image from public/uploads/advert_images
            if ($placement->image) {
                File::delete(public_path($placement->image));
            }

            //? delete placement from database
            $placement->delete();

            return response()->json(['status' => 'success', 'message' => 'Placement deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Error deleting placement: ' . $e->getMessage()], 500);
        }
    }


    public function delete(int $id)
    {
        //? delete advert
        try {
            //? find advert by id or fail
            $advert = Advert::findOrFail($id);

            foreach ($advert->placements as $placement) {
                //? delete image from public/uploads/advert_images
                if ($placement->image) {
                    File::delete(public_path($placement->image));
                }
            }

            //? delete advert from database and its placements through foreign key constraint
            $advert->delete();

            return response()->json(['status' => 'success', 'message' => 'Advert deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Error deleting advert: ' . $e->getMessage()], 500);
        }
    }


    public function advertFilter(Request $request)
    {
        try {
            //? validate request
            $request->validate([
                'status' => 'nullable|string|in:active,in-active',
                'start_date' => 'nullable|date_format:d-m-Y',
                'end_date' => 'nullable|date_format:d-m-Y',
            ]);

            //? build query
            $query = Advert::query();

            if ($request->has('status') && $request->status) {
                $query->where('status', $request->status);
            }

            if ($request->has('start_date') && $request->start_date) {
                $query->whereDate('start_date', '>=', Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d'));
            }

            if ($request->has('end_date') && $request->end_date) {
                $query->whereDate('end_date', '<=', Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d'));
            }

            //? get filtered adverts
            $adverts = $query->with(['user', 'placements'])
                ->latest()
                ->paginate(10)
                ->appends($request->query());


            return view('admin.advert.index', compact('adverts'));
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Error filtering adverts: ' . $e->getMessage()], 500);
        }
    }



    private function uploadImage(array $placement, string|int|null $advertPlacmentId = null): string
    {
        try {
            $directory = public_path('uploads/advert_images');

            //? Ensure the directory exists or create it
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            //? if advert placement id not null and image is set, delete the old image
            if (!is_null($advertPlacmentId) && isset($placement['image'])) {
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