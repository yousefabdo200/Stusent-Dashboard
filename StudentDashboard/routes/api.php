<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Teacher\TeacherController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix'=>'Admin'],function()
{
    Route::post('login',[AdminController::class,'login'])->name('login');
    Route::get('Home',[AdminController::class,'Home'])->name('Home');
    Route::post('create_teacher',[AdminController::class,'create_teacher'])->name('create_teacher');
    Route::post('create_student',[AdminController::class,'create_student'])->name('create_student');
    Route::get('view_teachers',[AdminController::class,'view_teacher'])->name('view_teacher');
    Route::get('view_students',[AdminController::class,'view_student'])->name('view_student');
    Route::get('select_student/{id}',[AdminController::class,'select_student'])->name('select_student');
    Route::get('select_teacher/{id}',[AdminController::class,'select_teacher'])->name('select_teacher');
    Route::get('update_teacher/{id}',[AdminController::class,'update_teacher'])->name('update_teacher');
    Route::get('update_student/{id}',[AdminController::class,'update_student'])->name('update_student');
    Route::get('delete_student/{id}',[AdminController::class,'delete_student'])->name('delete_student');
    Route::get('delete_teacher/{id}',[AdminController::class,'delete_teacher'])->name('delete_teacher');
    Route::get('logout',[AdminController::class,'logout'])->name('logout');

});
Route::group(['prefix'=>'Teacher'],function()
{
    Route::post('login',[TeacherController::class,'login'])->name('login');
    Route::get('Home',[TeacherController::class,'Home'])->name('Home');
    Route::get('logout',[TeacherController::class,'logout'])->name('logout');
    Route::get('classes',[TeacherController::class,'classes'])->name('classes');
    Route::post('creatclass',[TeacherController::class,'creatclass'])->name('creatclass');
    Route::get('single_class/{class_id}',[TeacherController::class,'single_class'])->name('single_class');
    Route::get('class_students/{class_id}',[TeacherController::class,'class_students'])->name('class_students');
    Route::post('add_student',[TeacherController::class,'add_student'])->name('add_student');
    Route::post('create_exam',[TeacherController::class,'create_exam'])->name('create_exam');
    Route::get('all_exams',[TeacherController::class,'all_exams'])->name('all_exams');
    Route::get('get_exam',[TeacherController::class,'get_exam'])->name('get_exam');
    Route::get('student_degrees',[TeacherController::class,'student_degrees'])->name('student_degrees');
    Route::post('set_degrees',[TeacherController::class,'set_degrees'])->name('set_degrees');

});