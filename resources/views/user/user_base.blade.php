<!DOCTYPE html> 
@extends("layouts.mcdn")
@section("title")
My Info 
@endsection

@section("headex")
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js" integrity="sha512-AIOTidJAcHBH2G/oZv9viEGXRqDNmfdPVPYOYKGy3fti0xIplnlgMHUGfuNRzC6FkzIo0iIxgFnr9RikFxK+sw==" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css" integrity="sha512-bYPO5jmStZ9WI2602V2zaivdAnbAhtfzmxnEGh9RwtlI00I9s8ulGe4oBa5XxiC6tCITJH/QG70jswBhbLkxPw==" crossorigin="anonymous" />
    @livewireStyles
@endsection
@section("context")
    <div class="row" style="margin:auto">
        <div class="col-xl-2">
            <div class="card">
                <div class="card-header">
                    <div class="text-center" style="font-weight: bold; font-size: x-large;">
                        Información <i class="far fa-id-card"></i>
                    </div>
                </div>
                <div class="card-body">                    
                    <a class="btn btn-md btn-outline-info w-100 my-1 text-info" href="my_info?section=1">Información de usuario</a>
                    <a class="btn btn-md btn-outline-info w-100 my-1 text-info" href="my_info?section=2">Formación</a>
                    <a class="btn btn-md btn-outline-info w-100 my-1 text-info" href="my_info?section=3">Documentos</a>
                    <a class="btn btn-md btn-outline-info w-100 my-1 text-info" href="my_info?section=4">Datos bancarios</a>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            @if (isset($_GET['section']))
                @if ($_GET['section'] == '1')
                    @include('user.user_info.user_form')  
                @elseif($_GET['section'] == '2')
                    @livewire('staff.formulario-estudios')
                @elseif($_GET['section'] == '3')
                    @include('user.user_documents.user_documents')    
                @elseif($_GET['section'] == '4')
                    @include('user.user_bank.user_bank_info')
                @else
                    @include('user.user_info.user_form') 
                @endif                 
            @else
                @include('user.user_info.user_form') 
            @endif
        </div>
        <div class="col-xl-2"></div>
    </div>

    @livewireScripts
@endsection