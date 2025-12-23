<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;

//category routes// استعملت الRoute Model Binding بدال ماحط الid

//create a new category
Route::post('/categories', [CategoryController::class, 'store']);

//list all categories
Route::get('/categories', [CategoryController::class, 'index']);

//show a single category
Route::get('/categories/{category}', [CategoryController::class, 'show']);

//update a category
Route::put('/categories/{category}', [CategoryController::class, 'update']);

//delete a category
Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

//EXTRA// Get all categories with all posts (in one request) using Eloquent relationships (with('posts'))
Route::get('/categories-with-posts', [CategoryController::class, 'categoriesWithPosts']);


//post routes//

//create a new post
Route::post('/posts', [PostController::class, 'store']);

//list all posts
Route::get('/posts', [PostController::class, 'index']);

//show a single post
Route::get('/posts/{post}', [PostController::class, 'show']);

//update a post
Route::put('/posts/{post}', [PostController::class, 'update']);

//delete a post 
Route::delete('/posts/{post}', [PostController::class, 'destroy']);
