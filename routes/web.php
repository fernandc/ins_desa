<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Google_api;
use App\Http\Controllers\App_Controller;
use App\Http\Controllers\View_System;
use App\Http\Controllers\MailController;

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


Route::get('/', [Google_api::class, 'login']);
Route::get('/status', function () {
    $ipAddress = $_SERVER['SERVER_ADDR'];
    $port      = $_SERVER['SERVER_PORT'];
    dd([$ipAddress,$port]);
});
Route::get('/g-response',[Google_api::class, 'user_data']);
Route::get('/change_period', [App_Controller::class, 'change_period']);
Route::get('/change_staff_status', [App_Controller::class, 'change_staff_status']);
Route::get('/change_staff_admin', [App_Controller::class, 'change_staff_admin']);
Route::get('/change_privilege', [App_Controller::class, 'change_privilege']);
Route::get('/add_new_period', [App_Controller::class, 'add_new_period']);
Route::get('/add_course', [App_Controller::class, 'add_course']);
Route::get('/add_student', [App_Controller::class, 'add_student']);
Route::get('/get_info', [App_Controller::class, 'get_info']);
Route::get('/add_user', [App_Controller::class, 'add_user']);
Route::get('/student_activate', [App_Controller::class, 'student_activate']);
Route::get('/add_subject', [App_Controller::class, 'add_subject']);
Route::get('/del_subject', [App_Controller::class, 'del_subject']);
Route::get('/set_jefatura', [App_Controller::class, 'set_jefatura']);
Route::get('/set_asignatura', [App_Controller::class, 'set_asignatura']);
Route::get('/create_group', [App_Controller::class, 'create_group']);
Route::get('/change_name_group', [App_Controller::class, 'change_name_group']);
Route::get('/add_student_to_group', [App_Controller::class, 'add_student_to_group']);
Route::get('/del_student_from_group', [App_Controller::class, 'del_student_from_group']);
Route::get('/change_student_section', [App_Controller::class, 'change_student_section']);
Route::post('/send_mail_info', [App_Controller::class, 'send_mail_info']);
Route::get('/change_student_CP', [App_Controller::class, 'change_student_CP']);
Route::get('/change_student_NM', [App_Controller::class, 'change_student_NM']);
Route::get('/change_student_FR', [App_Controller::class, 'change_student_FR']);
Route::get('/del_group', [App_Controller::class, 'del_group']);
Route::get('/eliminar_correo', [App_Controller::class, 'eliminar_correo']);
Route::get('/logout', [App_Controller::class, 'logout']);
Route::get('/new_new', [App_Controller::class, 'new_new']);
Route::get('/logo_ins', [App_Controller::class, 'logo_ins']);
Route::get('/save_block', [App_Controller::class, 'save_block']);
Route::get('/rmv_block',[App_Controller::class, 'rmv_block']);
Route::get('/enable_date',[App_Controller::class, 'enable_date']);
Route::get('/assistance_stu',[App_Controller::class, 'assistance_stu']);
Route::get('/full_assistance',[App_Controller::class, 'full_assistance']);
Route::get('/non_assistance',[App_Controller::class, 'non_assistance']);
Route::get('/save_assistance',[App_Controller::class, 'save_assistance']);
Route::get('/student_is_repeater',[App_Controller::class, 'student_is_repeater']);
Route::get('/student_is_new',[App_Controller::class, 'student_is_new']);
Route::post('/send_ticket',[App_Controller::class, 'send_ticket']);
Route::get('/close_ticket',[App_Controller::class, 'close_ticket']);
Route::post('/response_ticket_message',[App_Controller::class, 'response_ticket_message']);
Route::get('/get_ticket_messages',[App_Controller::class, 'get_ticket_messages']);
Route::get('/download',[App_Controller::class, 'download']);
Route::get('/modal_asignatura', [View_System::class, 'modal_asignatura']);
Route::get('/modal_privileges', [View_System::class, 'modal_privileges']);
Route::get('/modal_apoderados', [View_System::class, 'modal_apoderados']);
Route::get('/modal_ficha', [View_System::class, 'modal_ficha']);
Route::get('/modal_bloqueHorario', [View_System::class, 'modal_bloqueHorario']);
Route::get('/destinatarios_sent_mails', [View_System::class, 'destinatarios_sent_mails']);
Route::get('/modal_edit_group', [View_System::class, 'modal_edit_group']);
Route::get('/show_block', [View_System::class, 'show_block']);
Route::get('/list_teacher', [View_System::class, 'list_teacher']);
Route::get('/adm_schedule', [View_System::class, 'adm_schedule']);
Route::get('/iframe_news', [View_System::class, 'iframe_news']);
Route::get('/generatePDF', [View_System::class, 'generatePDF']);
Route::get('/validar', [View_System::class, 'validar']);
Route::post('/save_file_fm',[App_Controller::class, 'saveFile_FM']);
Route::get('/get_file/{path}', [App_Controller::class, 'get_file_FM']);
Route::post('/addFolder_FM', [App_Controller::class, 'addFolder_FM']);
Route::post('/renameItem_FM', [App_Controller::class, 'renameItem_FM']);
Route::get('/downloadFile_FM', [App_Controller::class, 'downloadFile_FM']);
Route::get('/deleteFile_FM', [App_Controller::class, 'deleteItem_FM']);
Route::post('/save_user_info', [App_Controller::class, 'save_user_info']);
Route::post('/user_bank_data', [App_Controller::class, 'user_bank_data']);
Route::post('/user_add_cert', [App_Controller::class, 'user_add_cert']);
Route::get('/user_del_cert', [App_Controller::class, 'user_del_cert']);
Route::get('/delete_degree_user', [App_Controller::class, 'delete_degree_user']);
Route::post('/add_staff_documents_from_adm', [App_Controller::class, 'add_staff_documents_from_adm']);
Route::get('/btn_del_document_adm', [App_Controller::class, 'btn_del_document_adm']);
Route::get('/staff_add_cargo', [App_Controller::class, 'staff_add_cargo']);
Route::get('/get_user_formation', [App_Controller::class, 'get_user_formation']);
Route::view('/ejemplos_livewire','ejemplos_livewire');
Route::get('/{param}',[View_System::class, 'main']);
Route::post('/delete_user', [App_Controller::class, 'delete_user']);

