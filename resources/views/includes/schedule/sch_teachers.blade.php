<thead>
    <tr>
        <th scope="col">Bloque</th>
        <th scope="col">Lunes</th>
        <th scope="col">Martes</th>
        <th scope="col">Miércoles</th>
        <th scope="col">Jueves</th>
        <th scope="col">Viernes</th>
        <th scope="col">Sábado</th>
    </tr>
    </thead>
    <tbody>
        @for ($j = 0; $j < 10; $j++)
            @php
                $cont = $j + 1;    
            @endphp
            <tr>
                <th>{{$cont}}</th>
                @for ($i = 0; $i < 6; $i++)
                    <td>
                        <div class="card"  id="card{{$i}}-{{$j}}">
                            <div class="card-header" id="headingOne{{$i}}-{{$j}}" style="background">
                                <h2 class="mb-0">
                                    <select class="form-control form-control-sm" id="sel{{$i}}-{{$j}}">
                                        <option selected>
                                            SELECCIONE
                                        </option>
                                        <option value="1" id="opt2">
                                            ASIGNATURA
                                        </option>
                                        <option value="2" id="opt2">
                                            RECESO
                                        </option>
                                    </select>
                                </h2>
                            </div>
                        </div>
                    </td>
                @endfor
            </tr>                
        @endfor
    </tbody>