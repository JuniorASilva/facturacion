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
                                        <input type="text" class="form-control" name="clientes" id="clientes" placeholder="Buscar por Dni o Apellidos">
                                        <input type="hidden" class="form-control" name="id_cliente" id="id_cliente">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-success" title="Nuevo Cliente" id="nuevo_cliente" data-toggle="tooltip">
                                                <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <label> Tipo Documento</label>
                                <select class="form-control" name="tipo_doc" id="tipo_doc">
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
                        <div class="col-lg-4 col-md-4 col-sm-4 ">
                            <label for="">&nbsp;</label><br>
                            <button type="button" class="btn btn-success pull-right"><i class="fa fa-plus"></i>Item </button>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="table">
                                <table class="table display table-striped table-bordered table-hover center" id="tabla-items">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Producto</th>
                                            <th scope="col">Precio</th>
                                            <th scope="col">Cantidad</th>
                                            <th scope="col">Impuesto</th>
                                            <th scope="col">Total</th>
                                            <th scope="col">&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
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
                                <span>I.G.V</span>
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
                            <label >Moneda</label>
                            <select class="form-control" name="" id="">
                                <option value="PEN">Soles</option>
                                <option value="DLR">Dolares</option>
                                <option value="EUR">Euros</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <button type="button" class="btn btn-success"><i class="fa fa-save"></i> Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script type="text/javascript">
$(document).on("focus",'.datepicker',function(){
        $(this).datepicker()
        
    });
    $(function () {
        $('.datepicker').datepicker()
        $('#tipo_doc').on('click',function(){
            if($(this).val()=='03'){
                $('#clientes').attr('placeholder','Nombre o DNI')
            }
            else
            {
                $('#clientes').attr('placeholder','Razon Social')
            }
        })
        var t_ventas = $('#tabla-items').DataTable({
            "lengthMenu":[[-1,10,15,20,30],["All",10,15,20,30]],
            "columns":[
                {"width":"10%"},
                {"width":"40%"},
                {"width":"10%"},
                {"width":"15%"},
                {"width":"15%"},
                {"width":"15%"},
                {"width":"15%"}
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
        $('#nuevo_cliente').on('click',function () {
            if ($('#tipo_doc').val()=='03'){

            
            $.confirm({
                title:'Agregar Cliente',
                columnClass:'col-lg-6 col-md-6 col-sm-6 offset-md-3 offset-lg-3 offset-sm-3',
                content: function(){
                    var self = this
                    return $.ajax({
                        url:'{{ route("util-documento") }}',
                        dataType:'JSON',
                        method:'POST',
                        data:{
                            _token:'{{ csrf_token() }}'
                        }
                    }).done(function(response){
                        if(response.status==200)
                        {
                            console.log(response.data)
                            let stringDocumentos='';
                            for(let i in response.data){
                                stringDocumentos+=`<option value="${response.data[i].id}">${response.data[i].nombre}</option>`;
                            }
                        self.setContentAppend(`<form class="formulario-persona">
                                                    <div class="row" style="margin-right:0px ;margin-left:0px;">
                                                        <div class="col-lg-6 col-md-6">
                                                            <label>Nombres *</label>
                                                            <input type="text" class="form-control" placeholder="Nombres" name="nombres" required>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6">
                                                            <label>Apellidos *</label>
                                                            <input type="text" class="form-control" placeholder="Apellidos" name="apellidos" required>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-right:0px ;margin-left:0px;">
                                                        <div class="col-lg-6 col-md-6">
                                                            <label>Tipo Documentos *</label>
                                                            <select class="form-control" name="tipo_doc">${stringDocumentos}</select>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6">
                                                            <label>Numero Documentos * </label>
                                                            <input type="text" class="form-control" placeholder="12345678" name="nro_doc" required>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-right:0px ;margin-left:0px;">
                                                        <div class="col-lg-6 col-md-6">
                                                            <label>Direccion</label>
                                                            <input type="text" class="form-control" placeholder="Av. Los cuchillos filudos" name="direccion">
                                                        </div>
                                                        <div class="col-lg-6 col-md-6">
                                                            <label>Fec.Nacimiento</label>
                                                            <input type="text" class="form-control datepicker" placeholder="{{ date('Y-m-d') }}" name="fec_nac">
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-right:0px ;margin-left:0px;">
                                                        <div class="col-lg-6 col-md-6">
                                                            <label>Telefono</label>
                                                            <input type="text" class="form-control" placeholder="952311111" name="telefono">
                                                        </div>
                                                        <div class="col-lg-6 col-md-6">
                                                            <label>Genero</label>
                                                            <select class='form-control'>
                                                                <option value="1">Masculino</option>
                                                                <option value="2">Femenino</option>
                                                                <option value="1">No Precisa</option>
                                                            </select>
                                                        </div>
                                                        @csrf
                                                    </div>
                                                </form>`)
                        }
                        else{
                            self.close()
                            toastr.error(response.message)
                        }
                    }).fail(function(){
                        self.close()
                        toastr.error('Error, consulte con su administrador');
                    })
                }, 
                contentLoaded: function(){},
                onContentReady: function(){
                    $('.datepicker').datepicker({
                        container: "body"
                    })
                },
                buttons:{
                    Guardar:{
                        text:'guardar',
                        keys:['enter'],
                        action: function(){
                            var self = this
                            if(!$('.formulario-persona').valid())
                            {
                                toastr.error('Ingrese los datos correctos')
                                return false
                            }
                            
                            var formularioPersona = self.$content.find('.formulario-persona').serialize()
                            $.confirm({
                                title:'Registrando',
                                content:function(){
                                    var self2=this
                                    return $.ajax({
                                        url:'{{ route("registro-cliente") }}',
                                        method:'POST',
                                        dataType:'JSON',
                                        data: formularioPersona

                                    }).done(function(response){
                                        if (response.status==200){
                                            toastr.success(response.message)
                                            self2.close();
                                            self.close();
                                            $('#clientes').val(response.data.nro_doc+'-'+response.data.apellidos+', '+response.data.nombres);
                                            $('#id_clientes').val(response.data.id_persona);
                                        }
                                        console.log(response)
                                        self2.close()
                                        return false
                                    }).fail(function(){
                                        self2.close()
                                        toastr.error('Error, consulte con su administrador.')
                                        return false
                                    })
                                }
                            })

                           /* toastr.success('Bienvenido')*/
                            return false
                        }
                    },
                    Cancelar:function(){}
                }
            })
        }
        else{
            $.confirm({
                title:`
                <form class="formulario-sunat" id="consulta-sunat">
                        @csrf
                            <div class="row" style="margin-rigth:0px; margin-left:0px;">
                                <div class="col-lg-12 col-md-12">
                                    <label>Ruc</label>
                                    <input type="text" class="form-control ruc" placeholder="Ingresar NUmero de RUC" name="ruc" required>
                                </div>
                            </div>
                        </form>
                        `,
                buttons:{
                    consultar:{
                        text:'Consultar',
                        btnClass:'btn-primary',
                        keys:['enter'],
                        action:function(){
                            var self=this
                            if(self.$content.find('.ruc').val()==''){
                                toastr.error('Ingrese un Ruc Valido')
                                return false
                            }
                            $.confirm({
                                title:'Consultando',
                                content:function(){
                                    var self2=this
                                    return $.ajax({
                                        url:'{{ route("consulta-ruc") }}',
                                        method:'POST',
                                        dataType:'JSON',
                                        //data: self.$content.find(".formulario-sunat").serialize(),
                                        data: $('#consulta-sunat').serialize(),
                                    }).done(function(response){
                                        console.log(response)
                                    }).fail(function(){
                                        toastr.error('Error,consulte con su administrador')
                                        self2.close()
                                    })
                                }
                            })
                            /*toastr.success('Consultando')
                            return false*/
                        }
                    },
                    cancelar:function(){}
                }

            })
        }
            
        })
        $('#clientes').autocomplete({
            serviceUrl:'{{ route("autocomplete-clientes") }}',
            minChars:3,
            dataType:'JSON',
            type:'POST',
            paramName:'clientes',
            params:{
                clientes: $('#clientes').val(),
                _token: '{{ csrf_token() }}'
            },
            onSelect:function(suggestions){
                $('#id_clientes').val(suggestions.data.id_persona);
            }
        })
    });
</script>

@endsection


