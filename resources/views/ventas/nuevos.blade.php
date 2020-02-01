@extends('body.body')

@section('contenido')
    <main class="main-content p-5" role="main">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Nueva de venta</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-horizontal">

                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <label>Cliente</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="cliente" placeholder="Busque por DNI o Apellidos">
                                        <div class="input-group-append">
                                            <button type="button" id="nuevo_cliente" class="btn btn-success" title="Nuevo Cliente" data-toggle="tooltip">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <label>Tipo de documento</label>
                                    <select class="form-control" name="tipo_doc" id="tipo_doc">
                                        <option value="03">Boleta</option>
                                        <option value="01">Factura</option>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <label>Fecha</label>

                                    <input type="text" name="fecha" class="form-control datepicker">
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 offset-lg-4 offset-md-4 offset-sm-4">
                                    <label>&nbsp;</label><br>
                                    <button type="button" class="btn btn-success pull-right">
                                        <i class="fa fa-plus"></i> Item
                                    </button>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="table">
                                        <table class="table display table-striped table-bordered table-hover center" id="tabla-items">
                                            <thead>
                                                <tr>
                                                    <th class="center">#</th>
                                                    <th class="center">Producto</th>
                                                    <th class="center">Precio</th>
                                                    <th class="center">Cantidad</th>
                                                    <th class="center">Impuesto</th>
                                                    <th class="center">Total</th>
                                                    <th class="center">&nbsp;</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6">

                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <span>Op. Gravada</span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <label>S/</label><label>0.00</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <span>Op. Inafecta</span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <label>S/</label><label>0.00</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <span>Op. Exonerada</span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <label>S/</label><label>0.00</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <span>I.G.V.</span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <label>S/</label><label>0.00</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <span>Total</span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <label>S/</label><label>0.00</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Moneda</label>
                                        <select class="form-control">
                                            <option value="PEN">Soles</option>
                                            <option value="DLR">Dolares</option>
                                            <option value="EUR">Euros</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-success">
                                            <i class="fa fa-save"></i> Guardar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        $(document).on('focus', '.datepicker', function () {
            $(this).datepicker()
        })

        $(function () {
            $('.datepicker').datepicker()
            $('#tabla-items').dataTable({
                "pageLength": 15,
                "language": {
                    "paginate": {
                        "first": "Primera página",
                        "last": "Ultima página",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "infoEmpty": "Observando 0 de 0 registros",
                    "info": "Observando pagina _PAGE_ de _PAGE_",
                    "lengthMenu": "Desplegando _MENU_ registros",
                    "sSearch": "Buscador"
                },
                "lengthMenu": [
                    [-1, 10, 15, 20, 30],
                    ["All", 10, 15, 20, 30]
                ]
            })

            // Evento para agregar un nuevo cliente
            $('#nuevo_cliente').on('click', function () {
                $.confirm({
                    title: 'Agregar Cliente',
                    columnClass: 'col-lg-8 col-md-8 col-sm-8',
                    
                    content: function() {
                        let self = this

                        return $.ajax({
                            url: '{{ route('util-documento') }}',
                            dataType: 'JSON',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}'
                            }
                        }).done(function (response) {
                            if (response.status == 200) {
                                console.log(response.data)

                                let stringDocumentos = ``

                                for (let i in response.data) {
                                    
                                    stringDocumentos += `
                                        <option value="${response.data[i].id}">${response.data[i].nombre}</option>
                                    `
                                }

                                /*html*/
                                self.setContentAppend(`
                                    <form class="formulario-persona">
                                        <div class="row" style="margin-right: 0px; margin-left: 0px;">
                                            <div class="col-lg-6 col-md-6">
                                                <label>Nombres *</label>
                                                <input type="text" class="form-control" placeholder="Nombres" name="nombres" required>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <label>Apellidos *</label>
                                                <input type="text" class="form-control" placeholder="Apellidos" name="apellidos" required>
                                            </div>
                                        </div>
                                        <br />
                                        <div class="row" style="margin-right: 0px; margin-left: 0px;">
                                            <div class="col-lg-6 col-md-6">
                                                <label>Tipo de documento *</label>
                                                <select class="form-control" required>
                                                    ${stringDocumentos}
                                                </select>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <label>Numero de documento *</label>
                                                <input type="text" class="form-control" placeholder="12345678" name="nro_doc" required>
                                            </div>
                                        </div>
                                        <br />
                                        <div class="row" style="margin-right: 0px; margin-left: 0px;">
                                            <div class="col-lg-6 col-md-6">
                                                <label>Direccion</label>
                                                <input type="text" class="form-control" placeholder="Av. Direccion" name="direccion">
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <label>Fecha de nacimiento</label>
                                                <input type="text" class="form-control datepicker" placeholder="{{ date('Y-m-d') }}" name="fch_nac">
                                            </div>
                                        </div>
                                        <br />
                                        <div class="row" style="margin-right: 0px; margin-left: 0px;">
                                            <div class="col-lg-6 col-md-6">
                                                <label>Telefono</label>
                                                <input type="text" class="form-control" placeholder="Telefono" name="telefono">
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <label>Genero</label>
                                                <select class="form-control" required>
                                                    <option value="1">Masculino</option>
                                                    <option value="2">Femenino</option>
                                                    <option value="3">Otros</option>
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                `)
                            } else {
                                self.close()
                                toastr.error(response.message)
                            }
                        }).fail(function (error) {
                            self.close()
                            toastr.error('Error, consulte con su administrador')
                        })
                    },
                    contentLoaded: function () {

                    },
                    onContentReady: function () {
                        $('.datepicker').datepicker({
                            container: 'body',
                        })
                    },
                    buttons: {
                        Guardar: {
                            text: 'Guardar',
                            keys: ['enter'],
                            btnClass: 'btn-primary',
                            action: function () {

                                if (!$('.formulario-persona').valid()) {
                                    toastr.error('Ingrese los datos correctos')
                                    return false
                                }

                                toastr.success('Bienvenido')
                                return false
                            }
                        },
                        Cancelar: {}
                    }
                })
            })
        })
    </script>

@endsection


