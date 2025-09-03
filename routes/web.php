<?php

declare(strict_types=1);

use App\Http\Controllers\Backend\ActionLogController;
use App\Http\Controllers\Backend\Auth\ScreenshotGeneratorLoginController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\LocaleController;
use App\Http\Controllers\Backend\MediaController;
use App\Http\Controllers\Backend\ModulesController;
use App\Http\Controllers\Backend\PermissionsController;
use App\Http\Controllers\Backend\PostsController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\RolesController;
use App\Http\Controllers\Backend\SettingsController;
use App\Http\Controllers\Backend\TermsController;
use App\Http\Controllers\Backend\TranslationController;
use App\Http\Controllers\Backend\UserLoginAsController;
use App\Http\Controllers\Backend\UsersController;
use App\Http\Controllers\Backend\HH\CandidatesController;
use App\Http\Controllers\Backend\HH\CompaniesController;
use App\Http\Controllers\Backend\HH\ApplicationsController;
use App\Http\Controllers\Backend\HH\JobListingController;
use App\Http\Controllers\Backend\HH\JobCategoryController;
use App\Http\Controllers\Backend\HH\ClientsController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rules\Can;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/home', [HomeController::class, 'index'])->name('home');

/**
 * Admin routes.
 */
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('roles', RolesController::class);
    Route::delete('roles/delete/bulk-delete', [RolesController::class, 'bulkDelete'])->name('roles.bulk-delete');

    // Permissions Routes.
    Route::get('/permissions', [PermissionsController::class, 'index'])->name('permissions.index');
    Route::get('/permissions/{id}', [PermissionsController::class, 'show'])->name('permissions.show');

    // Modules Routes.
    Route::get('/modules', [ModulesController::class, 'index'])->name('modules.index');
    Route::post('/modules/toggle-status/{module}', [ModulesController::class, 'toggleStatus'])->name('modules.toggle-status');
    Route::post('/modules/upload', [ModulesController::class, 'store'])->name('modules.store');
    Route::delete('/modules/{module}', [ModulesController::class, 'destroy'])->name('modules.delete');

    // Settings Routes.
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingsController::class, 'store'])->name('settings.store');

    // Translation Routes.
    Route::get('/translations', [TranslationController::class, 'index'])->name('translations.index');
    Route::post('/translations', [TranslationController::class, 'update'])->name('translations.update');
    Route::post('/translations/create', [TranslationController::class, 'create'])->name('translations.create');

    // Login as & Switch back.
    Route::resource('users', UsersController::class);
    Route::delete('users/delete/bulk-delete', [UsersController::class, 'bulkDelete'])->name('users.bulk-delete');
    Route::get('users/{id}/login-as', [UserLoginAsController::class, 'loginAs'])->name('users.login-as');
    Route::post('users/switch-back', [UserLoginAsController::class, 'switchBack'])->name('users.switch-back');

    // Action Log Routes.
    Route::get('/action-log', [ActionLogController::class, 'index'])->name('actionlog.index');

    // Content Management Routes

    // Posts/Pages Routes - Dynamic post types
    Route::get('/posts/{postType?}', [PostsController::class, 'index'])->name('posts.index');
    Route::get('/posts/{postType}/create', [PostsController::class, 'create'])->name('posts.create');
    Route::post('/posts/{postType}', [PostsController::class, 'store'])->name('posts.store');
    Route::get('/posts/{postType}/{id}', [PostsController::class, 'show'])->name('posts.show');
    Route::get('/posts/{postType}/{id}/edit', [PostsController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{postType}/{id}', [PostsController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{postType}/{id}', [PostsController::class, 'destroy'])->name('posts.destroy');
    Route::delete('/posts/{postType}/delete/bulk-delete', [PostsController::class, 'bulkDelete'])->name('posts.bulk-delete');

    // Terms Routes (Categories, Tags, etc.)
    Route::get('/terms/{taxonomy}', [TermsController::class, 'index'])->name('terms.index');
    Route::get('/terms/{taxonomy}/{term}/edit', [TermsController::class, 'edit'])->name('terms.edit');
    Route::post('/terms/{taxonomy}', [TermsController::class, 'store'])->name('terms.store');
    Route::put('/terms/{taxonomy}/{id}', [TermsController::class, 'update'])->name('terms.update');
    Route::delete('/terms/{taxonomy}/{id}', [TermsController::class, 'destroy'])->name('terms.destroy');
    Route::delete('/terms/{taxonomy}/delete/bulk-delete', [TermsController::class, 'bulkDelete'])->name('terms.bulk-delete');


    // Headhunters Routes.
    Route::prefix('headhunters')->name('headhunters.')->group(function () {

        // Candidates
        Route::prefix('candidates')->name('candidates.')->group(function () {
            Route::get('/', [CandidatesController::class, 'index'])->name('index');
            Route::get('/create', [CandidatesController::class, 'create'])->name('create');
            Route::post('/', [CandidatesController::class, 'store'])->name('store');
            Route::get('/{id}', [CandidatesController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [CandidatesController::class, 'edit'])->name('edit');
            Route::put('/{id}', [CandidatesController::class, 'update'])->name('update');
            Route::delete('/{id}', [CandidatesController::class, 'destroy'])->name('destroy');
            Route::delete('/bulk-delete', [CandidatesController::class, 'bulkDelete'])->name('bulk-delete');
        });

        // Companies
        Route::prefix('companies')->name('companies.')->group(function () {
            Route::get('/', [CompaniesController::class, 'index'])->name('index');
            Route::get('/create', [CompaniesController::class, 'create'])->name('create');
            Route::post('/', [CompaniesController::class, 'store'])->name('store');
            Route::get('/{id}', [CompaniesController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [CompaniesController::class, 'edit'])->name('edit');
            Route::put('/{id}', [CompaniesController::class, 'update'])->name('update');
            Route::delete('/{id}', [CompaniesController::class, 'destroy'])->name('destroy');
            Route::delete('/bulk-delete', [CompaniesController::class, 'bulkDelete'])->name('bulk-delete');
        });

        // Jobs
        Route::prefix('jobs')->name('jobs.')->group(function () {
            Route::get('/', [JobListingController::class, 'index'])->name('index');
            Route::get('/create', [JobListingController::class, 'create'])->name('create');
            Route::post('/', [JobListingController::class, 'store'])->name('store');
            Route::get('/{id}', [JobListingController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [JobListingController::class, 'edit'])->name('edit');
            Route::put('/{id}', [JobListingController::class, 'update'])->name('update');
            Route::delete('/{id}', [JobListingController::class, 'destroy'])->name('destroy');
            Route::delete('/bulk-delete', [JobListingController::class, 'bulkDelete'])->name('bulk-delete');
        });

        // Job Categories
        Route::prefix('job-categories')->name('job-categories.')->group(function () {
            Route::get('/', [JobCategoryController::class, 'index'])->name('index');
            Route::get('/create', [JobCategoryController::class, 'create'])->name('create');
            Route::post('/', [JobCategoryController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [JobCategoryController::class, 'edit'])->name('edit');
            Route::put('/{id}', [JobCategoryController::class, 'update'])->name('update');
            Route::delete('/{id}', [JobCategoryController::class, 'destroy'])->name('destroy');
            Route::delete('/bulk-delete', [JobCategoryController::class, 'bulkDelete'])->name('bulk-delete');
        });

        // Applications
        Route::prefix('applications')->name('applications.')->group(function () {
            Route::get('/', [ApplicationsController::class, 'index'])->name('index');
            Route::get('/create', [ApplicationsController::class, 'create'])->name('create');
            Route::post('/', [ApplicationsController::class, 'store'])->name('store');
            Route::get('/{id}', [ApplicationsController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [ApplicationsController::class, 'edit'])->name('edit');
            Route::put('/{id}', [ApplicationsController::class, 'update'])->name('update');
            Route::delete('/{id}', [ApplicationsController::class, 'destroy'])->name('destroy');
            Route::delete('/bulk-delete', [ApplicationsController::class, 'bulkDelete'])->name('bulk-delete');
        });
    });

    // Media Routes.
    Route::prefix('media')->name('media.')->group(function () {
        Route::get('/', [MediaController::class, 'index'])->name('index');
        Route::get('/api', [MediaController::class, 'api'])->name('api');
        Route::post('/', [MediaController::class, 'store'])->name('store')->middleware('check.upload.limits');
        Route::get('/upload-limits', [MediaController::class, 'getUploadLimits'])->name('upload-limits');
        Route::delete('/{id}', [MediaController::class, 'destroy'])->name('destroy');
        Route::delete('/', [MediaController::class, 'bulkDelete'])->name('bulk-delete');
    });

    // Editor Upload Route.
    Route::post('/editor/upload', [App\Http\Controllers\Backend\EditorController::class, 'upload'])->name('editor.upload');

    // AI Content Generation Routes.
    Route::prefix('ai')->name('ai.')->group(function () {
        Route::get('/providers', [App\Http\Controllers\Backend\AiContentController::class, 'getProviders'])->name('providers');
        Route::post('/generate-content', [App\Http\Controllers\Backend\AiContentController::class, 'generateContent'])->name('generate-content');
    });
});

/**
 * Profile routes.
 */
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'middleware' => ['auth']], function () {
    Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
    Route::put('/update', [ProfileController::class, 'update'])->name('update');
    Route::put('/update-additional', [ProfileController::class, 'updateAdditional'])->name('update.additional');
});

Route::get('/locale/{lang}', [LocaleController::class, 'switch'])->name('locale.switch');
Route::get('/screenshot-login/{email}', [ScreenshotGeneratorLoginController::class, 'login'])->middleware('web')->name('screenshot.login');
