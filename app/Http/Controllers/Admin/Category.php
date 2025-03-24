<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CategoryRequestUpdate;
use App\Models\Category as ModelsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Category extends Controller
{
    public function index()
    {
        //? get all categories
        $categories = ModelsCategory::latest()
            ->paginate(10)
            ->withQueryString();
        return view('admin.categories.index', compact('categories'));
    }

    public function addCategory()
    {
        return view('admin.categories.create');
    }

    public function storeCategory(CategoryRequest $request)
    {
        //? get validated inputs
        $validated = $request->safe();
        $name = Str::lower($validated['name']);

        //? store in database
        ModelsCategory::insert([
            'name' => $name,
            'slug' => Str::slug($name),
            'status' => 'active',
            'created_at' => now(),
        ]);

        //? redirect to all categories page
        return redirect()->route('admin.all.category')->with('status', 'Category Added Successfully');
    }

    public function editCategory(string|int $id)
    {
        $category = ModelsCategory::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function updateCategory(CategoryRequestUpdate $request)
    {
        //? find category by id and update
        $categoryName = Str::lower($request->name);
        ModelsCategory::where('id', $request->category_id)
            ->update([
                'name' => $categoryName,
                'slug' => Str::slug($categoryName),
                'updated_at' => now(),
            ]);

        //? redirect to all categories page
        return redirect()->route('admin.all.category')->with('status', 'Category Updated Successfully');
    }

    public function statusUpdate(string|int $id, string $status)
    {
        try {
            //? find category of fail
            $category = ModelsCategory::findOrFail($id);

            //? check if status params was right fully sent
            $expectedStatus = ['active', 'in-active'];

            if (!in_array($status, $expectedStatus)) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Expected 'active' or 'in-active', given '{$status}'"
                ], 400);
            }


            //? Update category status
            $category->update([
                'status' => $status,
                'updated_at' => now()
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Status updated successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occured on the server'
            ], 500);
        }
    }


    public function deleteCategory(string|int $id)
    {
        try {
            //? find category of fail
            $category = ModelsCategory::findOrFail($id);
            $category->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Status updated successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occured on the server'
            ], 500);
        }
    }
}
