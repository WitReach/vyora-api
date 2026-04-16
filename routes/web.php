<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstallerController;

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

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');
// Route::get('/pages/{slug}', [\App\Http\Controllers\StoreController::class, 'page'])->name('store.page');

// Installer Routes
Route::prefix('install')->name('install.')->group(function () {
    Route::get('/', [InstallerController::class, 'welcome'])->name('welcome');
    Route::get('/database', [InstallerController::class, 'database'])->name('database');
    Route::post('/database', [InstallerController::class, 'processDatabase'])->name('processDatabase');
    Route::get('/admin', [InstallerController::class, 'admin'])->name('admin');
    Route::post('/admin', [InstallerController::class, 'processAdmin'])->name('processAdmin');
});

// Auth Routes
Route::get('/login', [\App\Http\Controllers\Admin\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [\App\Http\Controllers\Admin\LoginController::class, 'login']);
Route::post('/logout', [\App\Http\Controllers\Admin\LoginController::class, 'logout'])->name('logout');

// Admin Dashboard Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard'); // Explicit admin dashboard

    // Products Management Group
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/search', [\App\Http\Controllers\Admin\ProductController::class, 'search'])->name('search');
        Route::get('/', [\App\Http\Controllers\Admin\ProductController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\ProductController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\ProductController::class, 'store'])->name('store');
        Route::get('/{product}/edit', [\App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('edit');
        Route::put('/{product}', [\App\Http\Controllers\Admin\ProductController::class, 'update'])->name('update');
        Route::delete('/{product}', [\App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('destroy');

        // Media routes
        Route::post('/{product}/media/upload', [\App\Http\Controllers\Admin\ProductMediaController::class, 'upload'])->name('media.upload');
        Route::post('/{product}/media/upload-preview', [\App\Http\Controllers\Admin\ProductMediaController::class, 'uploadMasterPreview'])->name('media.upload-preview');
        Route::delete('/{product}/media/{productImage}', [\App\Http\Controllers\Admin\ProductMediaController::class, 'delete'])->name('media.delete');
        Route::post('/{product}/media/{productImage}/primary', [\App\Http\Controllers\Admin\ProductMediaController::class, 'setPrimary'])->name('media.setPrimary');
        Route::post('/{product}/media/reorder', [\App\Http\Controllers\Admin\ProductMediaController::class, 'reorder'])->name('media.reorder');
    });

    // Reuse existing upload controller but link it conceptually under products
    Route::get('/upload', [\App\Http\Controllers\Admin\ProductUploadController::class, 'index'])->name('upload');
    Route::get('/upload/sample-qikink', [\App\Http\Controllers\Admin\ProductUploadController::class, 'downloadSampleQikink'])->name('upload.sample-qikink');
    Route::get('/upload/sample-general', [\App\Http\Controllers\Admin\ProductUploadController::class, 'downloadSampleGeneral'])->name('upload.sample-general');
    Route::post('/upload', [\App\Http\Controllers\Admin\ProductUploadController::class, 'store'])->name('upload.store');

    // Categories
    Route::post('/categories/reorder', [\App\Http\Controllers\Admin\CategoryController::class, 'reorder'])->name('categories.reorder');
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);

    // Collections
    Route::resource('collections', \App\Http\Controllers\Admin\CollectionController::class);

    // Attributes (Colors, Product Types)
    Route::get('/attributes', [\App\Http\Controllers\Admin\AttributeController::class, 'index'])->name('attributes.index');
    Route::post('/attributes/colors', [\App\Http\Controllers\Admin\AttributeController::class, 'storeColor'])->name('attributes.colors.store');
    Route::put('/attributes/colors/{color}', [\App\Http\Controllers\Admin\AttributeController::class, 'updateColor'])->name('attributes.colors.update');
    Route::delete('/attributes/colors/{color}', [\App\Http\Controllers\Admin\AttributeController::class, 'destroyColor'])->name('attributes.colors.destroy');
    Route::post('/attributes/types', [\App\Http\Controllers\Admin\AttributeController::class, 'storeType'])->name('attributes.types.store');
    Route::put('/attributes/types/{type}', [\App\Http\Controllers\Admin\AttributeController::class, 'updateType'])->name('attributes.types.update');
    Route::delete('/attributes/types/{type}', [\App\Http\Controllers\Admin\AttributeController::class, 'destroyType'])->name('attributes.types.destroy');
    Route::post('/attributes/sizes', [\App\Http\Controllers\Admin\AttributeController::class, 'storeSize'])->name('attributes.sizes.store');
    Route::put('/attributes/sizes/{size}', [\App\Http\Controllers\Admin\AttributeController::class, 'updateSize'])->name('attributes.sizes.update');
    Route::delete('/attributes/sizes/{size}', [\App\Http\Controllers\Admin\AttributeController::class, 'destroySize'])->name('attributes.sizes.destroy');

    // Size Charts
    Route::resource('size-charts', \App\Http\Controllers\Admin\SizeChartController::class);

    // Orders
    Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Online Store
    Route::prefix('online-store')->name('online-store.')->group(function () {
        // Theme Settings
        Route::get('/theme-settings', [\App\Http\Controllers\Admin\ThemeSettingsController::class, 'index'])->name('theme-settings.index');
        Route::post('/theme-settings', [\App\Http\Controllers\Admin\ThemeSettingsController::class, 'update'])->name('theme-settings.update');

        // General Settings
        Route::get('/general-settings', [\App\Http\Controllers\Admin\GeneralSettingsController::class, 'index'])->name('general-settings.index');
        Route::put('/general-settings', [\App\Http\Controllers\Admin\GeneralSettingsController::class, 'update'])->name('general-settings.update');

        // Policy Settings
        Route::get('/policy-settings', [\App\Http\Controllers\Admin\PolicySettingsController::class, 'index'])->name('policy-settings.index');
        Route::put('/policy-settings', [\App\Http\Controllers\Admin\PolicySettingsController::class, 'update'])->name('policy-settings.update');

        // Delivery PIN Settings
        Route::get('/delivery-pins', [\App\Http\Controllers\Admin\DeliveryPinController::class, 'index'])->name('delivery-pins.index');
        Route::post('/delivery-pins', [\App\Http\Controllers\Admin\DeliveryPinController::class, 'update'])->name('delivery-pins.update');

        // Product Card Settings
        Route::get('/product-card-settings', [\App\Http\Controllers\Admin\ProductCardSettingsController::class, 'index'])->name('product-card-settings.index');
        Route::put('/product-card-settings', [\App\Http\Controllers\Admin\ProductCardSettingsController::class, 'update'])->name('product-card-settings.update');

        // PDP Settings
        Route::get('/pdp-settings', [\App\Http\Controllers\Admin\PdpSettingsController::class, 'index'])->name('pdp-settings.index');
        Route::put('/pdp-settings', [\App\Http\Controllers\Admin\PdpSettingsController::class, 'update'])->name('pdp-settings.update');

        // Auth Settings
        Route::get('/auth-settings', [\App\Http\Controllers\Admin\AuthSettingsController::class, 'index'])->name('auth-settings.index');
        Route::put('/auth-settings', [\App\Http\Controllers\Admin\AuthSettingsController::class, 'update'])->name('auth-settings.update');

        // Navbar Settings
        Route::get('/navbar-settings', [\App\Http\Controllers\Admin\NavbarSettingsController::class, 'index'])->name('navbar-settings.index');
        Route::put('/navbar-settings', [\App\Http\Controllers\Admin\NavbarSettingsController::class, 'update'])->name('navbar-settings.update');

        // Coupons
        Route::resource('coupons', \App\Http\Controllers\Admin\CouponController::class);

        // CMS Pages (Placeholder for next step)
        Route::post('/mnpages/upload-image', [\App\Http\Controllers\Admin\PageUploadController::class, 'upload'])->name('mnpages.upload-image');
        Route::post('/mnpages/{mnpage}/auto-save', [\App\Http\Controllers\Admin\PageController::class, 'autoSave'])->name('mnpages.auto-save');
        Route::post('/mnpages/{mnpage}/publish', [\App\Http\Controllers\Admin\PageController::class, 'publish'])->name('mnpages.publish');
        Route::get('/mnpages/{mnpage}/design', [\App\Http\Controllers\Admin\PageController::class, 'design'])->name('mnpages.design');
        Route::resource('mnpages', \App\Http\Controllers\Admin\PageController::class);
    });
});
