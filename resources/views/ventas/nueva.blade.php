@extends('body/body')
@section('contenido')
<main class="main-content p-5" role="main">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3>Nueva Venta</h3>
                </div>
                <div class="card-body">
                    <div class="form-horizontal">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8">
                                <label >
                                    Cliente
                                </label>
                                <div class="input-group">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="clientes" placeholder="Buscar por Dni o Apellidos">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-success" title="Nuevo Cliente" data-toggle="tooltip">
                                                <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <label> Tipo Documento</label>
                                <select class="form-control" name="tipo_doc">
                                    <option value="03">Boleta</option>
                                    <option value="01">Factura</option>
                                </select>
                            </div>
                        </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <label for="">Fecha</label>
                            <input  type="text" name="fecha" class="form-control datepicker" >
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-lg-offset-4 col-md-offset-4 col-sm-offset-4">
                            <label for="">&nbsp;</label><br>
                            <button type="button" class="btn btn-success"><i class="fa fa-plus"></i>Item </button>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script type="text/javascript">
    $(function () {
        $('.datepicker').datepicker()
    })
</script>

@endsection