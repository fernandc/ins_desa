<!DOCTYPE html> 


@extends("layouts.mcdn")
@section("title")
Inicio
@endsection

@section("headex")

@endsection

@section("context")

<!DOCTYPE html>


<div class="container">
    <div class="row">
        @include('includes/info/today_list_scheduler')
    </div>
</div>


@endsection
