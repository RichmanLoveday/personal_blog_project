<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\TagRequestUpdate;
use App\Models\ArticleTag;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TagsController extends Controller
{
    public function index()
    {
        $tags = Tag::latest()
            ->paginate(5)
            ->withQueryString();

        return view('admin.tags.index', compact('tags'));
    }

    public function createTag()
    {
        return view('admin.tags.create');
    }

    public function storeTag(StoreTagRequest $request)
    {
        // dd($request);
        $name = Str::lower($request->name);
        $slug = Str::slug($name);

        //? add to tags table
        Tag::create([
            'user_id' => Auth::user()->id,
            'name' => $name,
            'slug' => $slug,
            'status' => 'active'
        ]);

        return redirect()->route('admin.tags')->with('status', 'Tag added successfully');
    }

    public function editTag(string|int $id)
    {
        $tag = Tag::findOrFail($id);
        return view('admin.tags.edit', compact('tag'));
    }

    public function updateTag(TagRequestUpdate $request)
    {
        $name = Str::lower($request->name);
        $slug = Str::slug($name);

        //? Update tag
        Tag::where('id', $request->id)
            ->update([
                'name' => $name,
                'slug' => $slug,
                'updated_at' => now()
            ]);

        return redirect()->route('admin.tags')->with('status', 'Tag updated successfully');
    }

    public function deleteTag(string|int $id)
    {
        try {
            //? find tag of fail
            $tag = Tag::findOrFail($id);
            $tag->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Tag deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occured on the server'
            ], 500);
        }
    }

    public function deleteArticleTag(string|int $tagId, string|int $articleId)
    {
        try {
            ArticleTag::where('tag_id', $tagId)
                ->where('article_id', $articleId)
                ->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Tag removed successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function updateTagStatus(Request $request)
    {
        try {
            //? find tag of fail
            $tag = Tag::findOrFail($request->id);

            //? check if status params was right fully sent
            $expectedStatus = ['active', 'in-active'];

            if (!in_array($request->status, $expectedStatus)) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Expected 'active' or 'in-active', given '{$request->status}'"
                ], 400);
            }

            //? Update tag status
            $tag->update([
                'status' => $request->status,
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


    public function searchTags(string $name)
    {
        try {
            $tags = Tag::where('name', 'LIKE', "%$name%")->latest()->get();

            return response()->json([
                'status' => 'success',
                'tags' => $tags,
                'message' => 'Tags retrived successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occured on the server'
            ], 500);
        }
    }
}
