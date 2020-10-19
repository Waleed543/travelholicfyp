<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Auth::routes();

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth','can:isAdmin'])->group(function () {

    Route::get('/','Admin\DashboardController@index')->name('admin');
    //Admin Dashboard
    Route::prefix('dashboard')->group(function () {

        //Dashboard Users
        Route::prefix('/user')->group(function () {
            //User Index
            Route::get('/','Admin\UserController@index')->name('admin.dashboard.user');
            //User Action
            Route::get('{user}/edit','Admin\UserController@edit')->name('admin.dashboard.user.edit');
            Route::get('/{user}/delete','Admin\UserController@destroy')->name('admin.dashboard.user.delete');
            //User Create
            Route::get('/create','Admin\UserController@create')->name('admin.dashboard.user.create');
            Route::post('/store','Admin\UserController@store')->name('admin.dashboard.user.store');
            //User Update
            Route::post('/update/{user}','Admin\UserController@update')->name('admin.dashboard.user.update');
            //User Settings
            Route::get('/setting','Admin\UserController@setting')->name('admin.dashboard.user.setting');
            //User Roles
            Route::get('/setting/role','Admin\UserController@indexRole')->name('admin.dashboard.user.setting.role');
            Route::get('/setting/create/role','Admin\UserController@createRole')->name('admin.dashboard.user.setting.create.role');
            Route::post('/setting/store/role','Admin\UserController@storeRole')->name('admin.dashboard.user.setting.store.role');
            Route::get('/setting/role/{role}/edit','Admin\UserController@editRole')->name('admin.dashboard.setting.role.edit');
            Route::post('/setting/update/{role}','Admin\UserController@updateRole')->name('admin.dashboard.user.setting.update.role');
            Route::get('/setting/role/{role}/delete','Admin\UserController@deleteRole')->name('admin.dashboard.user.setting.delete.role');
            //Add Blog Category
            //Route::post('/setting/add/category','Admin\UserController@addCategory')->name('admin.dashboard.blog.setting.add.category');
        });

        //Dashboard BLogs
        Route::prefix('/blog')->group(function () {
            Route::get('/','Admin\BlogController@index')->name('admin.dashboard.blog');
            Route::get('/create','Admin\BlogController@create')->name('admin.dashboard.blog.create');
            Route::get('/create', 'Admin\BlogController@create')->name('admin.dashboard.blog.create');
            Route::get('/{slug}/edit', 'Admin\BlogController@edit')->name('admin.dashboard.blog.edit');
            Route::delete('/{slug}', 'Admin\BlogController@destroy')->name('admin.dashboard.blog.delete');
            Route::get('/setting','Admin\BlogController@setting')->name('admin.dashboard.blog.setting');
            Route::post('/{slug}/status','Admin\BlogController@status')->name('admin.dashboard.blog.status');
            //Add Blog Category
            Route::post('/setting/add/category','Admin\BlogController@addCategory')->name('admin.dashboard.blog.setting.add.category');
        });

        //Tour Routes
        Route::prefix('/tour')->name('admin.dashboard.tour')->group(function () {
            Route::get('/', 'Admin\TourController@index');
            Route::post('/{slug}/status','Admin\TourController@status')->name('.status');
            Route::get('/create', 'Admin\TourController@create')->name('.create');
            Route::get('/{slug}/edit', 'Admin\TourController@edit')->name('.edit');
            Route::get('/{slug}/profile','Admin\TourController@profile')->name('.profile');
            Route::delete('/{slug}', 'Admin\TourController@destroy')->name('.delete');
            Route::get('/setting','Admin\TourController@setting')->name('.setting');
            Route::get('/search', 'Tour\TourSearchController')->name('.search');

            //Tour Tags
            Route::get('/setting/tag','Admin\TourController@indexTag')->name('.setting.tag');
            Route::get('/setting/create/tag','Admin\TourController@createTag')->name('.setting.create.tag');
            Route::post('/setting/store/tag','Admin\TourController@storeTag')->name('.setting.store.tag');
            Route::get('/setting/tag/{tag}/edit','Admin\TourController@editTag')->name('.setting.tag.edit');
            Route::post('/setting/update/{tag}','Admin\TourController@updateTag')->name('.setting.update.tag');
            Route::get('/setting/tag/{tag}/destroy','Admin\TourController@destroyTag')->name('.setting.destroy.tag');
            //
        });

        //Hotel Routes
        Route::prefix('/hotel')->name('admin.dashboard.hotel')->group(function () {
            Route::get('/', 'Admin\HotelController@index');
            Route::post('/{slug}/status','Admin\HotelController@status')->name('.status');
              Route::get('/create', 'Admin\HotelController@create')->name('.create');
             // Route::post('/update', 'Admin\HotelController@update')->name('.update');
              Route::get('/{slug}/edit', 'Admin\HotelController@edit')->name('.edit');
//            Route::get('/{slug}/profile','Admin\TourController@profile')->name('.profile');
//            Route::delete('/{slug}', 'Admin\TourController@destroy')->name('.delete');
              Route::get('/setting','Admin\HotelController@setting')->name('.setting');
//            Route::get('/search', 'Tour\TourSearchController')->name('.search');

              //Rooms Routes
               Route::prefix('/{slug}/room')->name('.room')->group(function () {
                   Route::get('/', 'Admin\RoomController@index')->name('.index');
                   Route::get('/create', 'Admin\RoomController@create')->name('.create');
                   Route::get('/store', 'Admin\RoomController@store')->name('.store');
                   Route::get('/edit/{room_slug}', 'Admin\RoomController@edit')->name('.edit');

               });




        });

    });
    //Admin Profile
    Route::prefix('profile')->group(function () {
        Route::get('/','Admin\ProfileController@index')->name('admin.profile');
        Route::post('/update','Admin\ProfileController@update')->name('admin.update.profile');
        Route::post('/update/image','Admin\ProfileController@updateImage')->name('admin.update.image');
        Route::post('/update/password','Admin\ProfileController@updatePassword')->name('admin.update.password');
    });

});
/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/

Route::get('/', 'HomeController@index')->name('home');
//User Profile
Route::prefix('profile')->middleware(['auth','can:notAdmin'])->group(function () {
    Route::get('/','User\ProfileController@index')->name('profile');
    Route::post('/update','User\ProfileController@update')->name('update.profile');
    Route::post('/update/image','User\ProfileController@updateImage')->name('update.image');
    Route::post('/update/password','User\ProfileController@updatePassword')->name('update.password');
});
//User Dashboard
Route::prefix('dashboard')->middleware(['auth','can:notAdmin'])->group(function () {
    Route::get('/', 'User\DashboardController@index')->name('dashboard');
    //Blog Routes
    Route::prefix('blog')->middleware(['auth','can:notAdmin'])->group(function () {
        Route::get('/', 'User\BlogController@index')->name('dashboard.blog');
        Route::get('/create', 'User\BlogController@create')->name('dashboard.blog.create');
        Route::get('/{slug}/edit', 'User\BlogController@edit')->name('dashboard.blog.edit');
        Route::delete('/{slug}', 'User\BlogController@destroy')->name('dashboard.blog.delete');
    });
    //Tour Routes
    Route::prefix('tour')->middleware(['auth','can:notAdmin'])->group(function () {
        Route::get('/', 'User\TourController@index')->name('dashboard.tour');
        Route::get('/create', 'User\TourController@create')->name('dashboard.tour.create');
        Route::get('/{slug}/edit', 'User\TourController@edit')->name('dashboard.tour.edit');
        Route::get('/{slug}/profile','User\TourController@profile')->name('dashboard.tour.profile');
        Route::delete('/{slug}', 'User\TourController@destroy')->name('dashboard.tour.delete');
        Route::get('/{slug}/status', 'User\TourController@status')->name('dashboard.tour.status.inactive');
    });
    //Hotel Routes
    Route::prefix('hotel')->middleware(['auth','can:notAdmin'])->group(function () {
        Route::get('/', 'User\HotelController@index')->name('dashboard.hotel');
        Route::get('/create', 'User\HotelController@create')->name('dashboard.hotel.create');
        Route::get('/{slug}/edit', 'User\HotelController@edit')->name('dashboard.hotel.edit');
        Route::get('/{slug}/profile','User\HotelController@profile')->name('dashboard.hotel.profile');
        Route::delete('/{slug}', 'User\HotelController@destroy')->name('dashboard.hotel.delete');
        Route::get('/{slug}/status', 'User\HotelController@status')->name('dashboard.hotel.status.inactive');
    });
    //My Bookings Routes
    Route::prefix('booking')->middleware(['auth','can:isStandard'])->group(function () {
        //Tour Book
        Route::get('/tour/{slug}','Tour\TourBookController@index')->name('dashboard.tour.book');
        Route::post('tour/{slug}/store','Tour\TourBookController@book')->name('dashboard.tour.book.store');
        Route::get('/tour/{slug}edit','Tour\TourBookController@edit')->name('dashboard.tour.book.edit');
        //Show Tour Bookings
        Route::get('/tour', 'User\BookingController@tour')->name('dashboard.tour.booking');

    });
});
/*
|--------------------------------------------------------------------------
| Blogs Routes
|--------------------------------------------------------------------------
*/

Route::prefix('blog')->group(function (){
    //Blogs Images Upload From tinymc
    Route::post('/upload','Blog\BlogController@upload')->name('blog.upload');
    //Search Route
    Route::get('/search', 'Blog\BlogSearchController')->name('blog.search');
    //Blog Comment
    Route::post('/comment/create','CommentController@blogCreate')->name('blog.comment.create');
    Route::post('/comment/delete','CommentController@blogDelete')->name('blog.comment.delete');

});
Route::resource('/blog','Blog\BlogController');

/*
|--------------------------------------------------------------------------
| Tour Routes
|--------------------------------------------------------------------------
*/

Route::get('/tag/name',function (){
    $tag = \App\Tag::all()->pluck('name')->toArray();
    return response($tag);
})->name('tag.name');
Route::post('/{slug}/profile','Tour\TourController@profile')->name('tour.profile.store');
Route::get('/tour/search', 'Tour\TourSearchController')->name('tour.search');
Route::resource('/tour','Tour\TourController');

/*
|--------------------------------------------------------------------------
| Hotel Routes
|--------------------------------------------------------------------------
*/

Route::resource('/hotel','Hotel\HotelController');
//rooms
Route::resource('/hotel/{slug}/room','Hotel\RoomController');



Route::get('/roomcheck','HomeController@index');





















