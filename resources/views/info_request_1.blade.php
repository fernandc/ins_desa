<!DOCTYPE html> 


@extends("layouts.mcdn")
@section("title")
Admin Cursos
@endsection

@section("headex")
<script>
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})
function getHeaderNames(table) {
    // Gets header names.
    //params:
    //  table: table ID.
    //Returns:
    //  Array of column header names.
    
    var header = $(table).DataTable().columns().header().toArray();

    var names = [];
    header.forEach(function(th) {
     names.push($(th).html());
    });
        
    return names;
  }
  
  function buildCols(data) {
    // Builds cols XML.
    //To do: deifne widths for each column.
    //Params:
    //  data: row data.
    //Returns:
    //  String of XML formatted column widths.
    
    var cols = '<cols>';
    
    for (i=0; i<data.length; i++) {
      colNum = i + 1;
      cols += '<col min="' + colNum + '" max="' + colNum + '" width="20" customWidth="1"/>';
    }
    
    cols += '</cols>';
    
    return cols;
  }
  
  function buildRow(data, rowNum, styleNum) {
    // Builds row XML.
    //Params:
    //  data: Row data.
    //  rowNum: Excel row number.
    //  styleNum: style number or empty string for no style.
    //Returns:
    //  String of XML formatted row.
    
    var style = styleNum ? ' s="' + styleNum + '"' : '';
    
    var row = '<row r="' + rowNum + '">';

    for (i=0; i<data.length; i++) {
      colNum = (i + 10).toString(36).toUpperCase();  // Convert to alpha
      var cr = colNum + rowNum;
      
      row += '<c t="inlineStr" r="' + cr + '"' + style + '>' +
              '<is>' +
                '<t>' + data[i] + '</t>' +
              '</is>' +
            '</c>';
    }
      
    row += '</row>';
        
    return row;
  }
function getTableData(table, title) {
    var header = getHeaderNames(table);
    var table = $(table).DataTable();
    var rowNum = 1;
    var mergeCells = '';
    var ws = '';
    ws += buildCols(header);
    ws += '<sheetData>';
    
    if (title.length > 0) {
      ws += buildRow([title], rowNum, 51);
      rowNum++;
      
      mergeCol = ((header.length - 1) + 10).toString(36).toUpperCase();
      
      mergeCells = '<mergeCells count="1">'+
        '<mergeCell ref="A1:' + mergeCol + '1"/>' +
                   '</mergeCells>';
    }
                      
    ws += buildRow(header, rowNum, 2);
    rowNum++;
    table.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
      var data = this.data();
      ws += buildRow(data, rowNum, '');
      rowNum++;
    } );
    ws += '</sheetData>' + mergeCells;
    return ws;
  }
function setSheetName(xlsx, name) {
    if (name.length > 0) {
      var source = xlsx.xl['workbook.xml'].getElementsByTagName('sheet')[0];
      source.setAttribute('name', name);
    }
  }
function addSheet(xlsx, table, title, name, sheetId) {
    var source = xlsx['[Content_Types].xml'].getElementsByTagName('Override')[1];
    var clone = source.cloneNode(true);
    clone.setAttribute('PartName','/xl/worksheets/sheet' + sheetId + '.xml');
    xlsx['[Content_Types].xml'].getElementsByTagName('Types')[0].appendChild(clone);
    var source = xlsx.xl._rels['workbook.xml.rels'].getElementsByTagName('Relationship')[0];
    var clone = source.cloneNode(true);
    clone.setAttribute('Id','rId'+sheetId+1);
    clone.setAttribute('Target','worksheets/sheet' + sheetId + '.xml');
    xlsx.xl._rels['workbook.xml.rels'].getElementsByTagName('Relationships')[0].appendChild(clone);
    var source = xlsx.xl['workbook.xml'].getElementsByTagName('sheet')[0];
    var clone = source.cloneNode(true);
    clone.setAttribute('name', name);
    clone.setAttribute('sheetId', sheetId);
    clone.setAttribute('r:id','rId'+sheetId+1);
    xlsx.xl['workbook.xml'].getElementsByTagName('sheets')[0].appendChild(clone);
    var newSheet = @php echo "\"<?xml version='1.0' encoding='UTF-8' standalone='yes' ?>\""; @endphp+
      '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" xmlns:mc="http://schemas.openxmlformats.org/markup-compatibility/2006" xmlns:x14ac="http://schemas.microsoft.com/office/spreadsheetml/2009/9/ac" mc:Ignorable="x14ac">'+
      getTableData(table, title) +
      
      '</worksheet>';

    xlsx.xl.worksheets['sheet' + sheetId + '.xml'] = $.parseXML(newSheet);
    
  }
</script>
@endsection

@section("context")

<div class="mx-2">
    <h2 style="text-align: center;" id="temp1">Descarga Listado de Alumnos 
        @if(Session::has('period'))
            {{Session::get('period')}}
        @endif
    </h2>
    @if(isset($message))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{$message}}',
                })
        </script>
    @endif
    <hr>
    <hr>
    <div class="table-responsive">
        @php
            $listas = array();
        @endphp
        @foreach($students as $row)
            @php
                $id_curso = $row["id_curso"];
                if (!isset($listas[$id_curso])) {
                    $listas[$id_curso] = array();
                }
                array_push($listas[$id_curso],$row);
            @endphp
        @endforeach
        <table class="table table-sm" style="text-align: center;" id="flag">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Nombre Alumno</th>
                    <th scope="col">Rut Alumno</th>
                    <th scope="col">Nombre Apoderado</th>
                    <th scope="col">Rut Apoderado</th>
                    <th scope="col">Dirección</th>
                    <th scope="col">Teléfono Apoderado</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <script>
            $(document).ready( function () {
                $('#flag').DataTable({
                        dom: 'Bftrip',
                        buttons: [
                            {
                                extend: 'excelHtml5',
                                text: 'Excel',
                                customize: function( xlsx ) {
                                    setSheetName(xlsx, 'Estructura');
                                    addSheet(xlsx, '#list_students_1', '', 'PreKinder', '2');
                                    addSheet(xlsx, '#list_students_2', '', 'Kinder', '3');
                                    addSheet(xlsx, '#list_students_3', '', 'Primero Básico', '4');
                                    addSheet(xlsx, '#list_students_4', '', 'Segundo Básico', '5');
                                    addSheet(xlsx, '#list_students_5', '', 'Tercero Básico', '6');
                                    addSheet(xlsx, '#list_students_6', '', 'Cuarto Básico', '7');
                                    addSheet(xlsx, '#list_students_7', '', 'Quinto Básico', '8');
                                    addSheet(xlsx, '#list_students_8', '', 'Sexto Básico', '9');
                                    addSheet(xlsx, '#list_students_9', '', 'Séptimo Básico', '10');
                                    addSheet(xlsx, '#list_students_10', '', 'Octavo Básico', '11');
                                    addSheet(xlsx, '#list_students_11', '', 'Primero Medio', '12');
                                    addSheet(xlsx, '#list_students_12', '', 'Segundo Medio', '13');
                                    addSheet(xlsx, '#list_students_13', '', 'Tercero Medio', '14');
                                    addSheet(xlsx, '#list_students_14', '', 'Cuarto Medio', '15');
                                }
                            }
                        ],
                        "ordering": true,
                        "order": [2, "asc" ],
                        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                        language: {
                            "decimal": "",
                            "emptyTable": "No hay información",
                            "info": "Mostrando _START_ a _END_ de _TOTAL_ Filas",
                            "infoEmpty": "Mostrando 0 to 0 of 0 Filas",
                            "infoFiltered": "(Filtrado de MAX total Filas)",
                            "infoPostFix": "",
                            "thousands": ",",
                            "lengthMenu": "Mostrar _MENU_ Filas",
                            "loadingRecords": "Cargando...",
                            "processing": "Procesando...",
                            "search": "Buscar:",
                            "zeroRecords": "Sin resultados encontrados",
                            "paginate": {
                                "first": "Primero",
                                "last": "Ultimo",
                                "next": "Siguiente",
                                "previous": "Anterior"
                                }
                        }
                    });
            } );
        </script>
        @for ($i = 1; $i <= 14; $i++)
            <table class="table table-sm" style="text-align: center;" id="list_students_{{$i}}">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Nombre Alumno</th>
                        <th scope="col">Rut Alumno</th>
                        <th scope="col">Nombre Apoderado</th>
                        <th scope="col">Rut Apoderado</th>
                        <th scope="col">Dirección</th>
                        <th scope="col">Teléfono Apoderado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($listas[$i] as $row)
                        <tr>
                            <td>{{$row["nombre_stu"]}} </td>
                            <td>{{$row["dni_stu"]}} </td>
                            <td>{{$row["nombre_apo"]}} </td>
                            <td> @php echo substr($row["dni"],0,-1)."-".substr($row["dni"],-1); @endphp </td>
                            <td>{{$row["direccion"]}} </td> 
                            <td>{{$row["cell_phone"]}} </td>
                        </tr>            
                    @endforeach                      
                </tbody>
            </table>
            <script>
                $(document).ready( function () {
                    $('#list_students_{{$i}}').DataTable({
                            "ordering": true,
                            "order": [2, "asc" ],
                            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                            language: {
                                "decimal": "",
                                "emptyTable": "No hay información",
                                "info": "Mostrando _START_ a _END_ de _TOTAL_ Filas",
                                "infoEmpty": "Mostrando 0 to 0 of 0 Filas",
                                "infoFiltered": "(Filtrado de MAX total Filas)",
                                "infoPostFix": "",
                                "thousands": ",",
                                "lengthMenu": "Mostrar _MENU_ Filas",
                                "loadingRecords": "Cargando...",
                                "processing": "Procesando...",
                                "search": "Buscar:",
                                "zeroRecords": "Sin resultados encontrados",
                                "paginate": {
                                    "first": "Primero",
                                    "last": "Ultimo",
                                    "next": "Siguiente",
                                    "previous": "Anterior"
                                    }
                            }
                        });
                } );
            </script>
        @endfor
    </div>
</div>
@endsection