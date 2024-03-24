<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\MessageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//маршрут выдачи токена
Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);
    $user = User::where('email', $request->email)->first();
    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }
    return $user->createToken($request->device_name)->plainTextToken;
});

//тестовая функция
Route::middleware('auth:sanctum')->post('/apitest', function () {
    return "view(welcome). You are in app. ";
});

//тестовая функция 2
Route::middleware('auth:sanctum')->post('/reporttest', [ReportController::class, 'test']);

//внесение отчёта в БД
Route::middleware('auth:sanctum')->post('/report/store', [ReportController::class, 'store']);

//редактирование отчёта в БД
Route::middleware('auth:sanctum')->post('/report/edit', [ReportController::class, 'edit']);

//удаление отчёта в БД
Route::middleware('auth:sanctum')->post('/report/delete', [ReportController::class, 'delete']);

//получение отчёта по id
Route::middleware('auth:sanctum')->post('/report', [ReportController::class, 'getReportById']);

//получение списка отчётов пользователя 
Route::middleware('auth:sanctum')->post('/myreports', [ReportController::class, 'userReports']);

//создать бизнес чат
Route::middleware('auth:sanctum')->post('/messenger/createchat',
                 [ConversationController::class, 'startConversation']);

//удалить бизнес чат
Route::middleware('auth:sanctum')->post('/messenger/deletechat',
                 [ConversationController::class, 'deleteConversation']);

//отправить сообщение в чат
Route::middleware('auth:sanctum')->post('/messenger/send', [MessageController::class, 'send']);

//удалить сообщение из чата
Route::middleware('auth:sanctum')->post('/messenger/deletemessage', 
                                            [MessageController::class, 'delete']);

//получить список бизнес чатов
Route::middleware('auth:sanctum')->post('/messenger/mychats',
                 [ConversationController::class, 'getMyConversations']);
                 
//получить чат по ид
Route::middleware('auth:sanctum')->post('/messenger/getChatById',
                 [ConversationController::class, 'getChatById']);