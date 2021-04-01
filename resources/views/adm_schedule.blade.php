<!DOCTYPE html> 
@extends("layouts.mcdn")
@section("title")
Horario de Clases
@endsection

@section("headex")

@endsection

@section("context")
<div class="container">
    <ul class="nav nav-tabs my-3 justify-content-center">
        <li class="nav-item">
            <a class="nav-link" data="1" href="adm_horario?curso=1">PK</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="2" href="adm_horario?curso=2">KI</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="3" href="adm_horario?curso=3">1B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="4" href="adm_horario?curso=4">2B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="5" href="adm_horario?curso=5">3B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="6" href="adm_horario?curso=6">4B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="7" href="adm_horario?curso=7">5B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="8" href="adm_horario?curso=8">6B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="9" href="adm_horario?curso=9">7B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="10" href="adm_horario?curso=10">8B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="11" href="adm_horario?curso=11">1M</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="12" href="adm_horario?curso=12">2M</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="13" href="adm_horario?curso=13">3M</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="14" href="adm_horario?curso=14">4M</a>
        </li>
        @php
            $active = 1;
        @endphp
        
        <script>
            $(document).ready(function(){
                $("[data={{$active}}]").addClass("active");
            });
        </script>
    </ul>
    <ul class="nav nav-tabs my-3 justify-content-center">
        <li class="nav-item" data=""><a class="nav-link" data="1" href=" ">Bloques de Horario</a></li>
        <li class="nav-item" data=""><a class="nav-link" data="2" href="sch_teacher">Profesores</a></li>
        @php
            $active = 1;
        @endphp
        <script>
            $(document).ready(function(){
                $("[data={{$active}}]").addClass("active");
            });
        </script>
    </ul>

    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="sch_course" role="tabpanel" aria-labelledby="sch_course-tab">
            @if (isset($grades))
                @foreach ($grades as $row)
                    @include('includes/schedule/sch_course?curso=9')
                @endforeach
            @endif
        </div> 
        <div class="tab-pane fade" id="sch_teacher" role="tabpanel" aria-labelledby="sch_teacher-tab">
            aaaa
            @include('includes/schedule/sch_teachers')
        </div>
    </div>
</div>
@endsection