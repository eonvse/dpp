<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PositionsController;
use App\Http\Controllers\CourseDirectionsController;
use App\Http\Controllers\TypeDocsController;
use App\Http\Controllers\InstitutionsController;
use App\Http\Controllers\TeachersController;
use App\Http\Controllers\CourseTypeController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\ReportsController;
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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/personal', [ProfileController::class, 'updatePersonal'])->name('profile.update.personal');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    /*--- Персональные данные ---*/
    //Route::get('/personal', [TeachersController::class, 'personal'])                    ->name('teachers.personal');
    //Route::get('/personal/edit',[TeachersController::class, 'personalEdit'])            ->name('teachers.personal.edit');  
    //Route::post('/personal/edit',[TeachersController::class, 'personalStore'])          ->name('teachers.personal.store');    
    //Route::get('/personal/export', [TeachersController::class, 'personalExport'])       ->name('export.personal');

    /*--- Персональные курсы ---*/
    Route::get('/personal/courses/', [CoursesController::class, 'personal'])                ->name('courses.personal');
    Route::get('/personal/courses/create',[CoursesController::class, 'personalCreate'])     ->name('courses.personal.create');
    Route::post('/personal/courses/create',[CoursesController::class, 'personalStore'])     ->name('courses.personal.store');
    Route::get('/personal/courses/edit/{id}',[CoursesController::class, 'personalEdit'])    ->name('courses.personal.edit');
    Route::get('/personal/courses/delete/{id}',[CoursesController::class, 'personalDel'])           
                                                                                            ->name('courses.personal.delete');
    Route::get('/personal/courses/deleteConfirm',[CoursesController::class, 'personalDelConfirm']) 
                                                                                            ->name('courses.personal.delete.confirm');
    /*--- Памятка---*/
    Route::get('/memo/user', [CoursesController::class, 'memo_user'])->name('memo.user');
 


});

Route::group(['middleware' => ['role:moderator']], function () {
    /*--- Педагоги ---*/
    Route::get('/teachers', [TeachersController::class, 'list'])                        ->name('teachers.list');
    Route::get('/teachers/create',[TeachersController::class, 'create'])                ->name('teachers.create');
    Route::post('/teachers/create',[TeachersController::class, 'store'])                ->name('teachers.store');
    Route::get('/teachers/edit/{id}',[TeachersController::class, 'edit'])               ->name('teachers.edit');
    Route::post('/teachers/update',[TeachersController::class, 'update'])               ->name('teachers.update');
    Route::get('/teachers/delete/{id}',[TeachersController::class, 'delete'])           ->name('teachers.delete');
    Route::post('/teachers/deleteConfirm',[TeachersController::class, 'deleteConfirm']) ->name('teachers.delete.confirm'); 

    /*--- Добавление уч. записи педагогу---*/
    Route::get('/users/add',[TeachersController::class, 'usersAddMod'])                     ->name('users.addMod');
    Route::post('/users/add',[TeachersController::class, 'usersAdd'])                       ->name('users.add');

    /*--- Курсы ДПП ---*/
    Route::get('/courses', [CoursesController::class, 'list'])                        ->name('courses.list');
    Route::get('/courses/create',[CoursesController::class, 'create'])                ->name('courses.create');
    Route::post('/courses/create',[CoursesController::class, 'store'])                ->name('courses.store');
    Route::get('/courses/edit/{id}/{idTeachers}',[CoursesController::class, 'edit'])  ->name('courses.edit');
    Route::post('/courses/update',[CoursesController::class, 'update'])               ->name('courses.update');
    Route::get('/courses/delete/{id}/{idTeachers}',[CoursesController::class, 'delete'])->name('courses.delete');
    Route::post('/courses/deleteConfirm',[CoursesController::class, 'deleteConfirm']) ->name('courses.delete.confirm'); 

    /*--- Отчеты ---*/
    Route::get('/report/teachers', [ReportsController::class, 'listTeachers'])        ->name('report.teachers');
    Route::get('/report/courses', [ReportsController::class, 'listCourses'])          ->name('report.courses');

    /*--- Экспорт в Excel ---*/
    Route::get('/teachers/export', [ReportsController::class, 'exportTeachers'])     ->name('export.teachers');
    Route::get('/courses/export', [ReportsController::class, 'exportCourses'])     ->name('export.courses');

    /*--- Памятка---*/
    Route::get('/memo/moderator', [CoursesController::class, 'memo_moderator'])->name('memo.moderator');

});

Route::group(['middleware' => ['role:admin']], function () {

    /*--- Пользователи (модераторы/без персональных данных)---*/
    Route::get('/users', [TeachersController::class, 'usersList'])                          ->name('users.list');
    Route::get('/users/personal/add/{idUser}',[TeachersController::class, 'personalAdd'])   ->name('users.personal.add');
    Route::post('/users/personal/store',[TeachersController::class, 'personalStore'])        ->name('users.personal.store');
    Route::post('/moderator/update',[TeachersController::class, 'moderatorUpdate'])         ->name('moderator.update');
    Route::post('/moderator/add',[TeachersController::class, 'moderatorAdd'])               ->name('moderator.add');
    Route::post('/moderator/del',[TeachersController::class, 'moderatorDel'])               ->name('moderator.del');
    Route::post('/users/update/{idUser}',[TeachersController::class, 'userUpdate']) ->name('user.update');

    /*Список справочником (для мобильной версии)*/
    Route::get('/guides', function(){
        return view('/guide.list');
    })    ->name('guides.list');

    /*--- Справочник направлений ДПП ---*/
    Route::get('/guide/directions', [CourseDirectionsController::class, 'list'])                        ->name('directions.list');
    Route::get('/guide/directions/create',[CourseDirectionsController::class, 'create'])                ->name('directions.create');
    Route::post('/guide/directions/create',[CourseDirectionsController::class, 'store'])                ->name('directions.store');
    Route::get('/guide/directions/edit/{id}',[CourseDirectionsController::class, 'edit'])               ->name('directions.edit');
    Route::post('/guide/directions/update',[CourseDirectionsController::class, 'update'])               ->name('directions.update');
    Route::get('/guide/directions/delete/{id}',[CourseDirectionsController::class, 'delete'])           ->name('directions.delete');
    Route::post('/guide/directions/deleteConfirm',[CourseDirectionsController::class, 'deleteConfirm']) ->name('directions.delete.confirm');    

    /*--- Справочник типов ДПП---*/
    Route::get('/guide/courseTypes', [CourseTypeController::class, 'list'])                        ->name('courseTypes.list');
    Route::get('/guide/courseTypes/create',[CourseTypeController::class, 'create'])                ->name('courseTypes.create');
    Route::post('/guide/courseTypes/create',[CourseTypeController::class, 'store'])                ->name('courseTypes.store');
    Route::get('/guide/courseTypes/edit/{id}',[CourseTypeController::class, 'edit'])               ->name('courseTypes.edit');
    Route::post('/guide/courseTypes/update',[CourseTypeController::class, 'update'])               ->name('courseTypes.update');
    Route::get('/guide/courseTypes/delete/{id}',[CourseTypeController::class, 'delete'])           ->name('courseTypes.delete');
    Route::post('/guide/courseTypes/deleteConfirm',[CourseTypeController::class, 'deleteConfirm']) ->name('courseTypes.delete.confirm');    

    /*--- Справочник должностей ---*/
    Route::get('/guide/positions', [PositionsController::class, 'list'])                        ->name('positions.list');
    Route::get('/guide/positions/create',[PositionsController::class, 'create'])                ->name('positions.create');
    Route::post('/guide/positions/create',[PositionsController::class, 'store'])                ->name('positions.store');
    Route::get('/guide/positions/edit/{id}',[PositionsController::class, 'edit'])               ->name('positions.edit');
    Route::post('/guide/positions/update',[PositionsController::class, 'update'])               ->name('positions.update');
    Route::get('/guide/positions/delete/{id}',[PositionsController::class, 'delete'])           ->name('positions.delete');
    Route::post('/guide/positions/deleteConfirm',[PositionsController::class, 'deleteConfirm']) ->name('positions.delete.confirm');    

    /*--- Справочник типов документов об образовании---*/
    Route::get('/guide/types', [TypeDocsController::class, 'list'])                        ->name('types.list');
    Route::get('/guide/types/create',[TypeDocsController::class, 'create'])                ->name('types.create');
    Route::post('/guide/types/create',[TypeDocsController::class, 'store'])                ->name('types.store');
    Route::get('/guide/types/edit/{id}',[TypeDocsController::class, 'edit'])               ->name('types.edit');
    Route::post('/guide/types/update',[TypeDocsController::class, 'update'])               ->name('types.update');
    Route::get('/guide/types/delete/{id}',[TypeDocsController::class, 'delete'])           ->name('types.delete');
    Route::post('/guide/types/deleteConfirm',[TypeDocsController::class, 'deleteConfirm']) ->name('types.delete.confirm');    

    /*--- Справочник учреждений ---*/
    Route::get('/guide/institutions', [InstitutionsController::class, 'list'])                        ->name('institutions.list');
    Route::get('/guide/institutions/create',[InstitutionsController::class, 'create'])                ->name('institutions.create');
    Route::post('/guide/institutions/create',[InstitutionsController::class, 'store'])                ->name('institutions.store');
    Route::get('/guide/institutions/edit/{id}',[InstitutionsController::class, 'edit'])               ->name('institutions.edit');
    Route::post('/guide/institutions/update',[InstitutionsController::class, 'update'])               ->name('institutions.update');
    Route::get('/guide/institutions/delete/{id}',[InstitutionsController::class, 'delete'])           ->name('institutions.delete');
    Route::post('/guide/institutions/deleteConfirm',[InstitutionsController::class, 'deleteConfirm']) ->name('institutions.delete.confirm'); 

});







require __DIR__.'/auth.php';
