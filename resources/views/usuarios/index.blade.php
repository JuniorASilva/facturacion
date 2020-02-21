@extends('body/body')
@section('contenido')

<main class="main-content p-5" role="main">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover" id="table-usuario">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombres</th>
                                <th scope="col">Usuario</th>
                                <th scope="col">Estado</th>
                                <th scope="col">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usuarios as $key=>$usuario)
                            
                                <tr>
                                    <td>{{ ($key+1) }}</td>
                                    <td>{{ $usuario->nombres }}</td>
                                    <td>{{ $usuario->usuario }}</td>
                                    @switch( $usuario->estado)
                                        @case(0)
                                            <td>Deshabilidado</td>        
                                            @break
                                        @case(1)
                                            <td>Habilitado</td>
                                            @break
                                        @case(2)
                                            <td>Designado</td>
                                            @break
                                        @default
                                            <td>Por Definir</td>
                                            @break
                                    @endswitch
                                    <td>
                                        <div class="row">
                                            <a class="btn btn-outline-success btn-sm"  
                                                data-toggle="tooltip" title="Editar Usuario"
                                                href="{{ route('editar-usuario',['id'=>$usuario->id]) }}" 
                                                >
                                                <i class="fa fa-edit"></i></a>
                                        </div>
                                    </td>               
                                </tr>
                            @endforeach              
                            
                        </tbody>
                    </table>
                    
                    <div class="row">
                        <a class="btn btn-outline-primary" href="{{ route('nuevo-usuario') }} "> Nuevo </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script type="text/javascript">
    $(function () {
        $('#table-usuario').DataTable({
            "lengthMenu":[[-1,10,15,20,30],["All",10,15,20,30]],
            "columns":[
                {"width":"10%"},
                {"width":"40%"},
                {"width":"15%"},
                {"width":"15%"},
                {"width":"20%"},
            ],
            "pageLength":15,
            "language":{
                "paginate":{
                    "first":"Primera Pagina",
                    "last":"Ultima Pagina",
                    "next":"Siguiente",
                    "previous":"Anterior",
                },
            "infoEmpty":"Observando 0 a 0 de 0 Registros",
            "info":"Observando Página _PAGE_ de _PAGE_",
            "lengthMenu":"Desplegando _MENU_ registros",
            "sSearch":"Buscar por:",
            
            }
        });
    });
</script>
@endsection