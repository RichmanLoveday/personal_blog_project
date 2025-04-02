<?php

use App\Http\Controllers\Admin\AdminAuthentication;
use App\Http\Controllers\Admin\AdminDashboard;
use App\Http\Controllers\Admin\Articles;
use App\Http\Controllers\Admin\Author;
use App\Http\Controllers\Admin\Category;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\TagsController;
use App\Http\Controllers\Author\Articles as AuthorArticles;
use App\Http\Controllers\Author\AuthorAuthentication;
use App\Http\Controllers\Author\AuthorDashboard;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Author\ProfileController;
use App\Http\Controllers\Author\TagsController as AuthorTagsController;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


//? ADMIN ROUTES
// Route::view('/home', 'index')->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/blogs', 'blogs')->name('blogs');
Route::view('/blog_detail', 'blog_detail');
Route::view('/category', 'category')->name('category');
Route::view('/contact', 'contact')->name('contact');
// Route::view('/admin/dashboard', 'admin/dashboard')->name('dashboard');
// Route::view('/admin/categories', 'admin/categories/index')->name('all.category');
// Route::view('/admin/category/add', 'admin/categories/create')->name('category.add');
// Route::view('/admin/tags', 'admin/tags/index')->name('all.tag');
// Route::view('/admin/tags/add', 'admin/tags/create')->name('tag_add');
// Route::view('/admin/articles', 'admin/articles/index')->name('all.articles');
// Route::view('/admin/articles/add', 'admin/articles/create')->name('article.add');
Route::view('/admin/articles/draft', 'admin/articles/draft')->name('article.draft');
Route::view('/admin/articles/published', 'admin/articles/published')->name('article.publish');
Route::view('/admin/adverts', 'admin/advert/index')->name('advert.index');
// Route::view('/admin/authors', 'admin/author/index')->name('all.author');
// Route::view('/admin/author/add', 'admin/author/create')->name('author.add');
// Route::view('/admin/author/profile', 'admin/author/profile')->name('author.profile');
Route::view('/admin/team-management', 'admin/teamManagement/index')->name('all.team.management');
Route::view('/admin/team-management/add', 'admin/teamManagement/create')->name('team.management.add');
Route::view('/admin/settings', 'admin/settings/index')->name('settings');
// Route::view('/admin/profile', 'admin/profile/index')->name('profile');


//? UNAUNTHENTICATED MIDDLEWARE FOR ADMIN, USER OR AUTHOR
Route::middleware(['guest'])->group(function () {
    Route::controller(AdminAuthentication::class)->group(function () {
        Route::get('/admin/login', 'create')->name('admin.login');
        Route::post('/admin/store', 'store')->name('admin.login.store');
    });

    Route::controller(AuthorAuthentication::class)->group(function () {
        Route::get('/author/login', 'create')->name('author.login');
        Route::post('/author/store', 'store')->name('author.login.store');
        Route::get('/author/forget-password', 'forgetPassword')->name('author.forgetPassword');
        Route::post('/author/forget-password', 'passwordResetLinkStore')->name('author.password.resetlink');
        Route::get('/author/password-reset/{token}', 'newPasswordCreate')->name('author.reset.password');
        Route::post('/author/password-reset', 'newPasswordStore')->name('author.reset.password.store');
    });
});


//? ADMIN MIDDLEWARES
Route::middleware(['auth', 'role:admin', 'isActive'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminAuthentication::class, 'destroy'])->name('admin.logout');

    Route::controller(Category::class)->group(function () {
        Route::get('/admin/categories', 'index')->name('admin.all.category');
        Route::get('/admin/category/add', 'addCategory')->name('admin.category.add');
        Route::post('/admin/category/store', 'storeCategory')->name('admin.category.store');
        Route::get('/admin/category/edit/{id}', 'editCategory')->name('admin.category.edit');
        Route::put('/admin/category/update', 'updateCategory')->name('admin.category.update');
        Route::put('/admin/category/statusUpdate/{id}/{status}', 'statusUpdate')->name('admin.category.status.update');
        Route::delete('/admin/category/delete/{id}', 'deleteCategory')->name('admin.category.delete');
    });

    Route::controller(Author::class)->group(function () {
        Route::get('/admin/authors', 'index')->name('admin.all.author');
        Route::get('/admin/author/add', 'createAuthor')->name('admin.author.create');
        Route::post('/admin/author/store', 'storeAuthor')->name('admin.author.store');
        Route::get('/admin/author/detail/{id}', 'viewAuthorDetails')->name('admin.author.profile');
        Route::put('/admin/author/statusUpdate/{id}/{status}', 'statusUpdate')->name('admin.author.status.update');
        Route::delete('/admin/author/deleteAuthor/{id}', 'deleteAuthor')->name('admin.author.delete');
        Route::get('/admin/authors/filter', 'filterByDate')->name('admin.author.filter');
    });

    Route::controller(AdminProfileController::class)->group(function () {
        Route::get('/admin/profile/{id}', 'index')->name('admin.profile');
        Route::put('/admin/change-password', 'changePassword')->name('admin.changepassword');
        Route::put('/admin/profile/update', 'update')->name('admin.profile.update');
        Route::put('/admin/update-profle-photo', 'updateProfilePhoto')->name('admin.update.profile.photo');
    });


    Route::controller(TagsController::class)->group(function () {
        Route::get('/admin/tags', 'index')->name('admin.tags');
        Route::get('/admin/tag/add', 'createTag')->name('admin.tag.create');
        Route::post('/admin/tag/store', 'storeTag')->name('admin.tag.store');
        Route::get('/admin/tag/edit/{id}', 'editTag')->name('admin.tag.edit');
        Route::put('/admin/tag/update', 'updateTag')->name('admin.tag.update');
        Route::put('/admin/tag/statusUpdate', 'updateTagStatus')->name('admin.tag.status.update');
        Route::delete('/admin/tag/delete/{id}', 'deleteTag')->name('admin.tag.delete');
        Route::delete('/admin/article/tag/delete/{tagId}/{articleId}', 'deleteArticleTag')->name('admin.article.tag.delete');
        Route::get('/admin/tags/search/{name}', 'searchTags')->name('author.tags.search');
    });


    Route::controller(Articles::class)->group(function () {
        Route::get('/admin/articles/', 'index')->name('admin.articles');
        Route::get('/admin/article/add', 'addArticle')->name('admin.article.create');
        Route::post('/admin/article/store', 'storeArticle')->name('admin.article.store');
        Route::get('/admin/article/edit/{id}', 'editArticle')->name('admin.article.edit');
        Route::put('/admin/article/publishment', 'publishment')->name('admin.publishment');
        Route::delete('/admin/article/delete/{id}', 'deleteArticle')->name('admin.article.delete');
        Route::put('/admin/article/updateNewsType', 'updateNewsType')->name('admin.article.updateNewsType');
        Route::put('/admin/article/update', 'updateArticle')->name('admin.article.update');
        Route::put('/admin/article/slider', 'updateSlider')->name('admin.article.slider.update');
        Route::put('/admin/article/updateStatus', 'updateStatus')->name('admin.article.update.status');
        Route::put('/admin/article/updateBannerTop', 'updateBannerTop')->name('admin.article.update.banner.top');
        Route::put('/admin/article/updateBannerBottom', 'updateBannerBottom')->name('admin.artcicle.update.banner.bottom');
        Route::get('/admin/article/search', 'articleFilter')->name('admin.article.filter');
    });
});



//? AUTHOR MIDDLEWARES
Route::middleware(['auth', 'role:author', 'isActive'])->group(function () {
    Route::get('/author/dashboard', [AuthorDashboard::class, 'index'])->name('author.dashboard');
    Route::get('/author/logout', [AuthorAuthentication::class, 'destroy'])->name('author.logout');

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/author/profile/{id}', 'index')->name('author.profile');
        Route::put('/author/change-password', 'changePassword')->name('author.changepassword');
        Route::put('/author/profile/update', 'update')->name('author.profile.update');
        Route::put('/author/update-profle-photo', 'updateProfilePhoto')->name('author.update.profile.photo');
    });

    Route::controller(AuthorArticles::class)->group(function () {
        Route::get('/author/articles/', 'index')->name('author.articles');
        Route::get('/author/article/add', 'addArticle')->name('author.article.create');
        Route::post('/author/article/store', 'storeArticle')->name('author.article.store');
        Route::get('/author/article/edit/{id}', 'editArticle')->name('author.article.edit');
        Route::put('/author/article/publishment', 'publishment')->name('author.publishment');
        Route::delete('/author/article/delete/{id}', 'deleteArticle')->name('author.article.delete');
        Route::put('/author/article/updateNewsType', 'updateNewsType')->name('author.article.updateNewsType');
        Route::put('/author/article/update', 'updateArticle')->name('author.article.update');
        Route::get('/author/article/search', 'articleFilter')->name('author.article.filter');
    });

    Route::controller(AuthorTagsController::class)->group(function () {
        Route::get('/author/tags/search/{name}', 'searchTags')->name('author.tags.search');
        Route::delete('/author/tag/delete/{tagId}/{articleId}', 'deleteTag')->name('author.tag.delete');
    });
});


//? FRONTEND CONTROLLER
Route::controller(FrontendController::class)->group(function () {
    Route::get('/home', 'index')->name('home');
    Route::get('/home/getArticlesByCategory/{id}', 'getArticlesByCategory')->name('home.get.articles.by.category');
    Route::get('/blog/{slug}', 'showBlog')->name('blog.show');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
