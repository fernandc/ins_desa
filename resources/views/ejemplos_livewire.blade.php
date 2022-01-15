<!DOCTYPE html> 
@extends("layouts.mcdn")

@section("title")
    Ejemplos
@endsection

@section("headex")
    @livewireStyles
@endsection

@section("context")
    @livewire('ejemplos',['newAge' => 28])
    @livewireScripts
@endsection