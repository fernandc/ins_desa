<!DOCTYPE html> 


@extends("layouts.mcdn")
@section("title")
Inicio
@endsection

@section("headex")
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.7/pdfobject.min.js" integrity="sha512-g16L6hyoieygYYZrtuzScNFXrrbJo/lj9+1AYsw+0CYYYZ6lx5J3x9Yyzsm+D37/7jMIGh0fDqdvyYkNWbuYuA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection

@section("context")

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
    </div>
    <script>
        const Message = Swal.mixin({
            customClass: {
                container: 'mt-5',
                popup: 'bg-warning',
                icon: 'text-primary bg-white',
                title: 'text-dark'
            },
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 10000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        Message.fire({
            icon: 'info',
            title: 'Recuerda Actualizar tu Información haciendo click en el botón: ',
            html: `<a class="btn btn-light mr-2" href="my_info" >
                    <img class="rounded-circle" src="{{ Session::get('account')["url_img"]}}" rel="Profile" height="22px" style="margin-top: -6px;margin-left: -4px;margin-right: 2px;">
                    {{ Session::get('account')["full_name"]}}
                </a> `
        });
    </script>
</div>


@endsection
