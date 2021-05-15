<!DOCTYPE html> 
@extends("layouts.mcdn")
@section("title")
Horario de Clases
@endsection

@section("headex")

@endsection

@section("context")
<div class="mx-2">
    <ul class="nav nav-tabs my-3 justify-content-center courses-ul">
        <li class="nav-item">
            <a class="nav-link" id="course1" href="adm_horario?curso=1">PK</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="course2" href="adm_horario?curso=2">KI</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="course3" href="adm_horario?curso=3">1B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="course4" href="adm_horario?curso=4">2B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="course5" href="adm_horario?curso=5">3B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="course6" href="adm_horario?curso=6">4B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="course7" href="adm_horario?curso=7">5B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="course8" href="adm_horario?curso=8">6B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="course9" href="adm_horario?curso=9">7B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="course10" href="adm_horario?curso=10">8B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="course11" href="adm_horario?curso=11">1M</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="course12" href="adm_horario?curso=12">2M</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="course13" href="adm_horario?curso=13">3M</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="course14" href="adm_horario?curso=14">4M</a>
        </li>
        @php
            $active = 1;
            $id_curso = null; 
        @endphp
        @if(isset($_GET['curso']))
            @php
               $active = $_GET['curso'];
            @endphp
        @endif
        @foreach ($grades as $item)
            @php
                if($item['id_curso'] == $active){
                    $id_curso = $item['id'];
                }
            @endphp
        @endforeach
        <script>
            $.ajax({
                type: "GET",
                url: "show_block",
                data:{
                    id_curso:"{{$id_curso}}",
                    current_course:"{{$active}}"
                },
                success: function (data){
                    $("#schedulecontent").html(data);
                }
            });
        </script>
        <script>
           
        </script>
        <script>
            $(document).ready(function(){
                $("#course{{$active}}").addClass("active");
            });
        </script>
    </ul>
    <div id="schedulecontent">

    </div>
</div>
@endsection