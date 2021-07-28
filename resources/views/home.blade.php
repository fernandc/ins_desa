<!DOCTYPE html> 


@extends("layouts.mcdn")
@section("title")
Inicio
@endsection

@section("headex")

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
    </div>
</div>


@endsection
