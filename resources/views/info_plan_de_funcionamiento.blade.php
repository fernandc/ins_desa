<!DOCTYPE html> 
@extends("layouts.mcdn")
@section("title")
    Plan de Funcionamiento
@endsection

@section("headex")

@endsection

@section("context")
    <div class="container">
        <h2>PLAN DE FUNCIONAMIENTO</h2>
        <div id="planfuncionamiento" style="height: 720px;"></div>
        <script>PDFObject.embed("https://saintcharlescollege.cl/pdf/plan_funcionamiento.pdf", "#planfuncionamiento");</script>
    </div>
@endsection