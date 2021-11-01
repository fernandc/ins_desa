<!DOCTYPE html> 


@extends("layouts.mcdn")
@section("title")
Inicio
@endsection

@section("headex")
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.7/pdfobject.min.js" integrity="sha512-g16L6hyoieygYYZrtuzScNFXrrbJo/lj9+1AYsw+0CYYYZ6lx5J3x9Yyzsm+D37/7jMIGh0fDqdvyYkNWbuYuA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection

@section("context")

<!DOCTYPE html>

@php
    $privileges = array();
    $array_privs = Session::get("privileges");
    foreach ($array_privs as $row) {
        array_push($privileges,$row["id_privilege"]);
    }
    if (Session::get('account')["is_admin"]=="YES") {
        for ($i=0; $i < 100; $i++) { 
            array_push($privileges,$i);
        }
    }
@endphp
<div class="container">
    <div class="row">
        @if (in_array(5,$privileges))
            @include('includes/info/today_list_scheduler')
        @endif
        <div class="col-md-6"></div>
        <div class="col-md-12 mt-3">
            <h2>PLAN DE FUNCIONAMIENTO</h2>
            <div id="planfuncionamiento" style="height: 720px;"></div>
            <script>PDFObject.embed("https://saintcharlescollege.cl/pdf/plan_funcionamiento.pdf", "#planfuncionamiento");</script>
        </div>
    </div>
</div>


@endsection
