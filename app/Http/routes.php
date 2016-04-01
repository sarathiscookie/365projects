<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

/*
|--------------------------------------------------------------------------
| Routes Files For frontend
|--------------------------------------------------------------------------
|
| Here is the all routes for frontend functionality
|
*/

Route::group(['middleware' => 'web'], function () {
    Route::auth();
/*
|--------------------------------------------------------------------------
| Routes for Facility Map
|--------------------------------------------------------------------------
|
| Routes for the functionality of facility map
*/
    /* View facility map */
    Route::get('/facilitymap', [
        'as' => 'facilitiesmap', 'uses' => 'FacilitymapController@index'
    ]);

    /* Show facilities in map */
    Route::get('/facilitymap/show', [
        'as' => 'facilitiesmap', 'uses' => 'FacilitymapController@show'
    ]);







    //Front-end Search
    Route::get('/searchtext', 'SearchController@generateSearchText'); //Test Mode
    Route::get('/searchpage', 'SearchController@index'); //Test Mode
    Route::get('/search', 'SearchController@search'); //Test Mode


});

/*
|--------------------------------------------------------------------------
| Routes Files For BACKEND
|--------------------------------------------------------------------------
|
| Here is the all routes for backend functionality
|
*/

/**/

Route::group(['middleware' => 'admin'], function () {
    Route::auth();
    Route::group(['namespace'=>'backend'], function () {
        Route::get('/home', 'HomeController@index');
        //----------Facilities-----------
        Route::get('/facilities', 'FacilityController@listFacilities');
        Route::get('/facilities/create', 'FacilityController@showCreate');
        Route::post('/facilities/save', 'FacilityController@createFacility');
        Route::post('/facilities/update', 'FacilityController@updateFacility');
        Route::get('/facilities/edit/{id}', 'FacilityController@showEdit')->where('id', '[0-9]+');
        Route::get('/facilities/images/{id}', 'FacilityController@showFacilityImages')->where('id', '[0-9]+');
        Route::post('/facilities/upload/{id}', 'FacilityController@uploadImages')->where('id', '[0-9]+');
        Route::get('/facility-image/{path}', 'FacilityController@getImageOriginal')
            ->where('path', '[A-Za-z0-9\/\-\.\+]+');
        Route::post('/facilities/image/delete', 'FacilityController@unlinkImage');
        //----------END Facilities-----------

        //----------Facility Team-----------
        Route::get('/facility/team/{id}', 'TeamController@listTeam')->where('id', '[0-9]+');
        Route::get('/facility/team/create/{id}', 'TeamController@showCreate')->where('id', '[0-9]+');
        Route::post('/facility/team/save', 'TeamController@createTeamMember');
        Route::post('/facility/team/update', 'TeamController@updateTeamMember');
        Route::get('/facility/team/edit/{id}', 'TeamController@showEdit')->where('id', '[0-9]+');
        Route::post('/facility/team/delete', 'TeamController@deleteTeamMember');
        Route::get('/facility/team/image/{id}', 'TeamController@showMemberImage')->where('id', '[0-9]+');
        Route::post('/facility/team/upload/{id}', 'TeamController@storeMemberImage')->where('id', '[0-9]+');
        Route::post('/facility/teamImage/delete/{id}', 'TeamController@destroyMemberImage')->where('id', '[0-9]+');
        //----------END Facility Team-----------

        //----------Facility Profile-----------
        Route::get('/facility/profile/{id}', 'FacilityprofileController@showFacility')->where('id', '[0-9]+');
        //----------END Facility Profile-----------

/*
|--------------------------------------------------------------------------
| Routes for Offer
|--------------------------------------------------------------------------
|
| Routes for list, add, edit and update offers
*/

        /* List offer details */
        Route::get('/facility/offer/{id}', [
            'as' => 'offerlist', 'uses' => 'OfferController@show'
        ]);

        /* View offer form */
        Route::get('/facility/offer/{id}/create', [
            'as' => 'offerform', 'uses' => 'OfferController@index'
        ]);

        /* Store offer details */
        Route::post('/facility/offer/{id}/save', [
            'as' => 'saveoffer', 'uses' => 'OfferController@store'
        ]);

        /* View edit offer form */
        Route::get('/facility/offer/edit/{id}', [
            'as' => 'editofferform', 'uses' => 'OfferController@edit'
        ]);

        /* Update offer details */
        Route::post('/facility/offer/update/{id}', [
            'as' => 'updateofferdetails', 'uses' => 'OfferController@update'
        ]);
        /* Update offer details */
        Route::post('/facility/offer/delete/{id}', [
            'as' => 'deleteoffer', 'uses' => 'OfferController@destroy'
        ]);

/*
|--------------------------------------------------------------------------
| Routes for Offer Dates
|--------------------------------------------------------------------------
*/


        /* Save offer dates - Ajax*/
        Route::post('/offer/offerdate/save', 'OfferdateController@store');
        Route::post('/offer/offerdate/update', 'OfferdateController@update');

/*
|--------------------------------------------------------------------------
| Route for Contact
|--------------------------------------------------------------------------
|
| All the functionality of contact form
*/

        /* Send contact details and View contact form */
        Route::resource('contact', 'ContactformController', ['only' => [
            'index', 'store'
        ]]);
    });
});