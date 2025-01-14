<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HealthCheckController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuestionVoteController;
use Illuminate\Routing\Router;

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

/** @var Router $router */

$router->view('/', 'welcome')->name('home');
$router->resource('photos', PhotoController::class)->only('index', 'create', 'store');

// Remove QA routes.
//$router->view('/qa', 'qa.index')->name('qa.index');
//$router->apiResource('questions', QuestionController::class)->except('destroy');
//$router->post('/questions/{question}/vote', QuestionVoteController::class . '@store');

$router->get('auth/login', LoginController::class . '@index')->name('auth.login');
$router->get('auth/logout', LoginController::class . '@logout')->name('auth.logout');
$router->post('auth/login', LoginController::class . '@attempt');

$router->middleware('auth:web')->group(
    function (Router $router) {
        $router->resource('admin', AdminController::class)->only('index');
    }
);

// Health Check for ELB
$router->resource('health-check', HealthCheckController::class)->only('index');
