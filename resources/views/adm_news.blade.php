@extends("layouts.mcdn")
@section("title")
    Comunicaciones
@endsection

@section("headex")

@endsection

@section("context")
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <form class="card-body" method="GET" action="new_new">
                        <h5 class="card-title">Nueva Comunicación </h5>
                        <div class="form-group">
                            <label for="title">Título <span class="text-danger">Requerido</span></label>
                            <input type="text" class="form-control" id="title" name="title" minlength="6" required="">
                        </div>
                        <div class="form-group">
                            <label for="subtitle">Subtítulo</label>
                            <input type="text" class="form-control" id="subtitle" name="subtitle">
                        </div>
                        <div class="form-group">
                            <label for="body">Cuerpo <span class="text-danger">Requerido</span></label>
                            <textarea class="form-control" id="body" name="body" rows="3" required=""></textarea>
                        </div>
                        <div class="form-group">
                            <label for="url">Link URL</label>
                            <input type="text" class="form-control" id="url" name="url" >
                        </div>
                        <div class="form-group">
                            <label for="textlink">Texto Link</label>
                            <input type="text" class="form-control" id="textlink" name="textlink" >
                        </div>
                        <button type="submit" class="btn btn-primary">Agregar</button>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card" >
                    <div class="card-body">
                        <h5 class="card-title">Título de la Comunicación (Ejemplo)</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Subtítulo opcional</h6>
                        <p class="card-text">Cuerpo</p>
                        <a href="#" class="card-link">Link opcional</a>
                    </div>
                </div>
                <hr>
                <h5>Comunicaciones Publicadas</h5>
                @if(isset($news))
                    @foreach ($news as $new)
                    <div class="card bg-light mt-2" >
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted" style="text-align: right;">{{$new["date_in"]}}</h6>
                            <h5 class="card-title">{{$new["title"]}}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{$new["subtitle"]}}</h6>
                            <p class="card-text" style="white-space: pre-wrap;max-height: 190px;overflow-y: auto;">{{$new["body"]}}</p>
                            <a href="{{$new["url"]}}" target="_blank" class="card-link">{{$new["text_url"]}}</a>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection