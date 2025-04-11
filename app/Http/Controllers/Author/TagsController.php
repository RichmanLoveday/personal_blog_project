<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\ArticleTag;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagsController extends Controller
{
    public function searchTags(string $name)
    {
        try {
            $adminId = User::where('role', 'admin')->first()->id;

            //? query table to only get data related to admin or current authenticated user
            $tags = Tag::with(['user'])
                ->where(function ($query) use ($adminId) {
                    $query->where('user_id', Auth::user()->id)
                        ->orWhere('user_id', $adminId);
                })
                ->where('name', 'LIKE', "%$name%")
                ->where('status', 'active')
                ->latest()
                ->get();

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


    public function deleteTag(string|int $tagId, string|int $articleId)
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
}
