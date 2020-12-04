<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/',['as' => 'frontend.index',      'uses' => 'Frontend\IndexController@index']);


//Autentication route for frontend
   Route::get('/login',                            ['as' => 'front.show_login_form',                 'uses' => 'Frontend\Auth\LoginController@showLoginForm']);
   Route::post('login',                            ['as' => 'front.login',                           'uses' => 'Frontend\Auth\LoginController@login']);
   Route::post('logout',                           ['as' => 'front.logout',                          'uses' => 'Frontend\Auth\LoginController@logout']);
   Route::get('register',                          ['as' => 'front.show_register_form',              'uses' => 'Frontend\Auth\RegisterController@showRegistrationForm']);
   Route::post('register',                         ['as' => 'front.register',                        'uses' => 'Frontend\Auth\RegisterController@register']);
   Route::get('password/reset',                    ['as' => 'front.password.request',                'uses' => 'Frontend\Auth\ForgotPasswordController@showLinkRequestForm']);
   Route::post('password/email',                   ['as' => 'password.email',                         'uses' => 'Frontend\Auth\ForgotPasswordController@sendResetLinkEmail']);
   Route::get('password/reset/{token}',            ['as' => 'password.reset',                         'uses' => 'Frontend\Auth\ResetPasswordController@showResetForm']);
   Route::post('password/reset',                   ['as' => 'password.update',                        'uses' => 'Frontend\Auth\ResetPasswordController@reset']);
   Route::get('email/verify',                      ['as' => 'verification.notice',                   'uses' => 'Frontend\Auth\VerificationController@show']);
   Route::get('/email/verify/{id}/{hash}',         ['as' => 'verification.verify',                   'uses' => 'Frontend\Auth\VerificationController@verify']);
   Route::post('email/resend',                     ['as' => 'verification.resend',                   'uses' => 'Frontend\Auth\VerificationController@resend']);

   //user dashboard
   Route::group(['middleware' => 'verified'] , function(){
   Route::get('/dashboard',     ['as' => 'frontend.dashboard',       'uses' => 'Frontend\UsersController@index']);
   Route::get('/create-post',   ['as' => 'users.post.create',       'uses' => 'Frontend\UsersController@create_post']);
   Route::post('/create-post',  ['as' => 'users.post.store',       'uses' => 'Frontend\UsersController@store_post']);
   Route::get('/edit-post/{post_id}',   ['as' => 'users.post.edit',       'uses' => 'Frontend\UsersController@edit_post']);
   Route::post('/update-post/{post_id}',  ['as' => 'users.post.update',       'uses' => 'Frontend\UsersController@update_post']);
  
   Route::delete('/delete-post/{post_id}',  ['as' => 'users.post.delete',       'uses' => 'Frontend\UsersController@delete_post']);
  
   Route::post('/delete-post-media/{media_id}',   ['as' => 'post.media.destroy',      'uses' => 'Frontend\UsersController@destroy_post_media']);
  
   });

   Route::get('/contact-us', ['as' => 'front.contact', 'uses' => 'Frontend\IndexController@contact']);
   Route::post('/contact-us', ['as' => 'front.add_contact', 'uses' => 'Frontend\IndexController@add_contact']);


   Route::get('/search', ['as' => 'post.search', 'uses' => 'Frontend\IndexController@search']);
   Route::get('/category/{category_slug}', ['as' => 'category.posts', 'uses' => 'Frontend\IndexController@category']);
   Route::get('/archive/{date}', ['as' => 'archive.posts', 'uses' => 'Frontend\IndexController@archive']);
   Route::get('/author/{username}', ['as' => 'author.posts', 'uses' => 'Frontend\IndexController@author']);
   Route::get('/{post}', ['as' => 'post.show','uses' => 'Frontend\IndexController@show_post']);
   Route::post('/{post}', ['as' => 'post.add_comment', 'uses' => 'Frontend\IndexController@store_comment']);