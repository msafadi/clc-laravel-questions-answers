<?php

use App\Http\Controllers\AnswersController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\UserProfileController;
use App\Http\Middleware\Localization;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/dashboard/chart', [DashboardController::class, 'chart'])
    ->middleware(['auth'])
    ->name('dashboard.chart');

Route::get('/dashboard/chart/tags', [DashboardController::class, 'tagsChart'])
    ->middleware(['auth'])
    ->name('dashboard.chart.tags');

require __DIR__ . '/auth.php';

Route::group([
    //'middleware' => ['locale'],
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localizationRedirect', 'localeViewPath'],
], function () {

    Route::get('/', [QuestionsController::class, 'index']);

    // route('tags.index') -> /tags
    // tags/tags
    Route::prefix('tags')
        ->as('tags.')
        ->middleware(['user.type:admin,super-admin'])
        ->group(function () {
            Route::get('/', [TagsController::class, 'index'])
                ->name('index');
            Route::get('/create', [TagsController::class, 'create'])
                ->name('create');
            Route::post('/', [TagsController::class, 'store'])
                ->name('store');
            Route::get('/{id}/edit', [TagsController::class, 'edit'])
                ->name('edit');
            Route::put('/{id}', [TagsController::class, 'update'])
                ->name('update');
            Route::delete('/{id}', [TagsController::class, 'destroy'])
                ->name('destroy');
        });

    Route::resource('roles', RolesController::class)
        ->middleware(['auth', 'user.type:admin,super-admin']);

    Route::resource('questions', QuestionsController::class);

    Route::group([
        'middleware' => 'auth',
    ], function () {

        Route::get('notifications', [NotificationsController::class, 'index'])
            ->name('notifications');

        Route::get('profile', [UserProfileController::class, 'edit'])
            ->name('profile');
        Route::put('profile', [UserProfileController::class, 'update']);

        Route::get('password/change', [ChangePasswordController::class, 'create'])
            ->name('password.change');
        Route::post('password/change', [ChangePasswordController::class, 'store']);

        Route::post('answers', [AnswersController::class, 'store'])
            ->name('answers.store');

        Route::put('answers/{id}/best', [AnswersController::class, 'best'])
            ->name('answers.best');
    });
});

Route::get('/storage/{file}', function ($file) {

    $filepath = storage_path('app/public/' . $file);
    if (!is_file($filepath)) {
        abort(404);
    }

    return response()->file($filepath);
})->where('file', '.*');

Route::get('/test/public', function () {
    return public_path();
});
