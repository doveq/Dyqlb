<?php

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


/**
 * 前台路由
*/
Route::get('/', 'Index\IndexController@index');

/**
 * 后台路由
*/
Route::get('/admin', 'Admin\UsersController@login');

// 页面跳转提示
Route::get('/admin/prompt', 'Admin\PromptController@index')->name('admin.prompt');

// 帖子管理
Route::get('/admin/posts', 'Admin\PostsController@index')->name('admin.posts.index');
Route::get('/admin/posts/create', 'Admin\PostsController@create')->name('admin.posts.create');
Route::post('/admin/posts/store', 'Admin\PostsController@store')->name('admin.posts.store');
Route::get('/admin/posts/edit', 'Admin\PostsController@edit')->name('admin.posts.edit');
Route::post('/admin/posts/update', 'Admin\PostsController@update')->name('admin.posts.update');
Route::get('/admin/posts/delete', 'Admin\PostsController@delete')->name('admin.posts.delete');
