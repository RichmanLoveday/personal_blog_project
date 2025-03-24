<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class Articles extends Controller
{
    public function index()
    {
        $articles = Article::with(['tags', 'category', 'user'])
            ->where('user_id', Auth::user()->id)
            ->where('status', 'active')
            ->latest()
            ->paginate(20)
            ->withQueryString();

        //dd($articles);

        return view('author.articles.index', compact('articles'));
    }

    public function addArticle()
    {
        $categories = Category::where('status', 'active')
            ->latest()
            ->get();

        return view('author.articles.create', compact('categories'));
    }

    public function storeArticle(StoreArticleRequest $request)
    {
        DB::beginTransaction();
        try {
            $tagIds = [];

            if ($request->has('tags')) {
                $tags = explode(',', $request->tags);
                $tagIds = $this->checkIfTagExist($tags);
            }

            $filePath = $this->uploadImage($request);

            $article = Article::create([
                'user_id' => Auth::user()->id,
                'category_id' => $request->category,
                'title' => $request->title,
                'text' => $request->description1,
                'slug' => Str::lower(Str::slug($request->title)),
                'status' => 'active',
                'published_at' => $request->status == 'published' ? now() : null,
                'is_trending' => $request->has('trending_news') ? true : false,
                'is_featured' => $request->has('featured_news') ? true : false,
                'image' => $filePath,
            ]);

            //? add data to many relationship
            if (!empty($tagIds)) $article->tags()->sync($tagIds);

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Article created successfully!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    private function checkIfTagExist(array $tags): array
    {
        $tagIds = [];
        DB::beginTransaction();
        try {
            foreach ($tags as $tag) {
                $tagToLower = Str::lower($tag);
                $existingTag = Tag::where('name', $tagToLower)->first();

                if (!$existingTag) {
                    $existingTag = Tag::create([
                        'name' => $tagToLower,
                        'slug' => Str::slug($tagToLower),
                        'user_id' => Auth::user()->id,
                        'status' => 'active',
                    ]);
                }

                array_push($tagIds, $existingTag->id);
            }

            DB::commit();
            return $tagIds;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function uploadImage(Request $request, string|int $articleId = null): string
    {
        try {
            $directory = public_path('uploads/article_images');

            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true, true);
            }

            if (!is_null($articleId)) {
                $articleImg = Article::where('id', $articleId)->first()->image;
                File::delete(public_path($articleImg));
            }

            $file =  $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            // $image = Image::read($file);

            // //? Resize image
            // $image->resize(300, 300, function ($constraint) {
            //     $constraint->aspectRatio();
            // })->save(public_path("uploads/article_images/$fileName"));

            $file->move(public_path('uploads/article_images'), $fileName);

            return "uploads/article_images/$fileName";
        } catch (\Exception $e) {
            throw $e;
        }
    }


    public function editArticle(string|int $id)
    {
        $article = Article::with(['category', 'tags', 'user'])
            ->where('user_id', Auth::user()->id)
            ->where('id', $id)
            ->where('status', 'active')
            ->first();

        $categories = Category::where('status', 'active')->get();

        // dd($article);
        if (!$article) abort(404);

        return view('author.articles.edit', compact('article', 'categories'));
    }

    public function updateArticle(UpdateArticleRequest $request)
    {
        DB::beginTransaction();
        try {
            //? find article created by current user
            $article = Article::where('id', $request->articleId)
                ->where('user_id', Auth::user()->id)
                ->where('status', 'active')
                ->first();

            //? if article is not found or is inactive
            if (!$article) {
                throw new \Exception("Article not found or not active.");
            }

            $tagIds = [];
            if ($request->has('tags') && !is_null($request->tags)) {
                $tags = explode(',', $request->tags);
                $tagIds = $this->checkIfTagExist($tags);
            }

            // dd($tagIds);
            //? check if image was given
            if ($request->has('image')) {
                $filePath = $this->uploadImage($request, $request->articleId);
                $article->image = $filePath;
            }

            //? update articles
            $article->category_id = $request->category;
            $article->text = $request->description1;
            $article->title = $request->title;
            $article->slug = Str::lower(Str::slug($request->title));
            $article->published_at = $request->status == 'published' ? now() : null;
            $article->is_trending = $request->has('trending_news') ? true : false;
            $article->is_featured = $request->has('featured_news') ? true : false;
            $article->updated_at = now();

            //? save
            $article->save();

            //? add data to many relationship
            //  if (!empty($tagIds)) $article->tags()->sync($tagIds);
            if (!empty($tagIds)) $article->tags()->syncWithoutDetaching($tagIds);


            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Article updated successfully!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function publishment(Request $request)
    {
        try {
            $article = Article::findOrFail($request->id);

            $expectedValue = ['publish', 'unpublish'];

            if (!in_array($request->status, $expectedValue)) {
                throw new \Exception('Wrong status value given.');
            }

            //? update publish at column
            $article->update([
                'published_at' => $request->status == 'publish' ? now() : Null,
                'updated_at' => now(),
            ]);


            $statusInfo = $request->status == 'publish' ? 'published' : 'unpublished';

            return response()->json([
                'status' => 'success',
                'article' => $article,
                'message' => "Article $statusInfo successfully",
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function deleteArticle(string|int $id)
    {
        try {
            $artilce = Article::where('id', $id)
                ->where('user_id', Auth::user()->id)
                ->where('status', 'active')
                ->first();


            //? delete respective image
            File::delete(public_path($artilce->image));

            //? delete article
            $artilce->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Article deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function updateNewsType(Request $request)
    {
        try {
            $article = Article::findOrFail($request->id);

            $expectedValue = ['is_trending', 'is_featured'];

            if (!in_array($request->status, $expectedValue)) {
                throw new \Exception('Wrong news type value given');
            }

            //? udpate table
            $article->update([
                $request->newsType => $request->value,
            ]);

            return response()->json([
                'status' => 'success',
                'article' => $article,
                'message' => 'News type updated successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}