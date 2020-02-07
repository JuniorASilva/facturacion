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
                        			<label>Cliente</label>
                        			<div class="input-group mb-3">
                        			<input type="text" class="form-control" placeholder="Busque por DNI o Apellidos" aria-label="Busque por DNI o Apellidos" aria-describedby="basic-addon2" name="cliente" id="cliente">
                                    <input type="hidden" name="id_cliente" id="id_cliente">
										<div class="input-group-append">
											<button class="btn btn-primary  active" id="nuevo_cliente" type="button" title="Nuevo Cliente" data-toggle="tooltip"><i class="fa fa-plus"></i></button>
										</div>
									</div>
                        			
                        		</div>

                        		<div class="col-lg-4 col-md-4 col-sm-4">
                        			<label>Tipo Documento</label>
                        			<select class="form-control" name="tipo_doc">
                        				<option value="03">Boleta</option>
                        				<option value="01">Factura</option>
                        			</select>
                        	    </div>
                        	</div>
                        	<div class="row">
                        		<div class="col-lg-4 col-md-4 col-sm-4">
                        			<label>Fecha</label>
                        			<input type="text" name="fecha" class="form-control datepicker">
                        		</div>
                        		<div class="col-lg-8 col-md-8 col-sm-8">
                        			<label>&nbsp;</label><br>
                        			<button type="button" class="btn btn-primary btn-sm  active pull-right "><i class="fa fa-plus"></i>&nbsp;&nbsp;Item</button>
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
                                            <label>S/.</label><label>0.00</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <span>Op. Inafecta</span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <label>S/.</label><label>0.00</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <span>Op. Exonerada</span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <label>S/.</label><label>0.00</label>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <span>I.G.V.</span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <label>S/.</label><label>0.00</label>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <span>Total</span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <label>S/.</label><label>0.00</label>
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


                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                            
                                <button type="button" class="btn btn-success active pull-right"><i class="fa fa-save"></i>&nbsp;&nbsp;Guardar</button>
                            
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script type="text/javascript">
    	$(function(){
    		$('.datepicker').datepicker()
    	})
    </script>
    <script type="text/javascript">
        $(document).on("focus",'.datepicker',function(){
            $(this).datepicker()
        })
    $(function(){
        
        $('#tabla-items').dataTable({
            "lengthMenu": [[-1,10,15,20,30],["All",10,15,20,30]],
            
            "pageLength":15,
            "language":{
                "paginate":{
                    "first":"Primera página",
                    "last": "Ultima página",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "infoEmpty": "Observando 0 a 0 de 0 registros",
                "info": "Observando página _PAGE_ de _PAGE_",
                "lengthMenu":"Desplegando _MENU_ registros",
                "sSearch": "Buscador"
            }
        });
        $('#nuevo_cliente').on('click',function(){
            $.confirm({
                title:'Agrega Cliente',
                columnClass: 'col-lg-6 col-md-6 col-sm-6 offset-md-3 offset-lg-3 offset-sm-3',
                content: function(){
                    var self = this
                    return $.ajax({
                        url: '{{ route('util-documento') }}',
                        dataType: 'JSON',
                        method: 'POST',
                        data: {
                            _token:'{{ csrf_token() }}'
                        }
                    }).done(function(response){
                        if(response.status ==200){
                            console.log(response.data)
                            let stringDocumentos =''
                            for(let i in response.data){
                                stringDocumentos += '<option value="'+response.data[i].id+'">'+response.data[i].nombre+'</option>'
                            }
                            self.setContentAppend(`<form class="formulario-persona"><div class="row" style="margin-right:0px;margin-left:0px"><div class="col-lg-6 col-md-6"><label>Nombres *</label><input type="text" class="form-control" placeholder="Nombres"name="nombres" required></div><div class="col-lg-6 col-md-6"><label>Apellidos *</label><input type="text" class="form-control" placeholder="Apellidos" name="apellidos" required></div></div><br><div class="row" style="margin-right:0px;margin-left:0px"><div class="col-lg-6 col-md-6"><label>Tipo Documento *</label><select class="form-control" name="tipo_doc">${stringDocumentos}</select></div><div class="col-lg-6 col-md-6"><label>N° Documento *</label><input type="text" class="form-control" placeholder="12345678" name="nro_doc" required></div></div><br><div class="row" style="margin-right:0px;margin-left:0px"><div class="col-lg-6 col-md-6"><label>Dirección</label><input type="text" class="form-control" placeholder="Av. Grau" name="direccion"></div><div class="col-lg-6 col-md-6"><label>Fecha de Nacimiento *</label><input type="text" class="form-control datepicker" placeholder="{{ date('Y-m-d')}}" name="fch_nac"></div></div><br><div class="row" style="margin-right:0px;margin-left:0px"><div class="col-lg-6 col-md-6"><label>Teléfono</label><input type="text" class="form-control" placeholder="949586762" name="telefono"></div><div class="col-lg-6 col-md-6"><label>Genero</label><select class="form-control"><option value="1">Hombre</option><option value="2">Mujer</option><option value="3">Otro</option></select></div>@csrf</div></form>`)
                        }
                        else{
                            self.close()
                            toastr.error('Error, consulte con su administrador')
                        }
                    }).fail(function(){
                        self.close()
                        toastr.error('Error, consulte con su administrador')
                    })
                },
                contentLoaded: function(){},
                onContentReady: function(){
                    $('.datepicker').datepicker({
                        container: "body"
                    })
                },
                buttons: {
                    Guardar: {
                        text: 'Guardar',
                        btnClass: 'btn-primary active',
                        keys: ['enter'],
                        action: function(){
                            var self = this
                            if(!$('.formulario-persona').valid()){
                                toastr.error('Ingrese los datos correctos')
                                return false
                            }
                            
                            var formularioPersona = self.$content.find('.formulario-persona').serialize()
                            $.confirm({
                                title: 'Registrando',
                                content:function(){
                                    var self2 = this
                                     return $.ajax({
                                        url: '{{ route("registro-cliente") }}',
                                        method: 'POST',
                                        dataType: 'JSON',
                                        data: formularioPersona
                                    }).done(function(response){
                                        if(response.status ==200){
                                            toastr.success(response.message)
                                            self2.close()
                                            self.close()
                                            $('#cliente').val(response.data.nro_doc+' - '+response.data.apellidos+' '+response.data.nombres)
                                            $('#id_cliente').val(response.data.id_persona)
                                        }else{
                                            toastr.error(response.message)
                                            self2.close()
                                            return false
                                        }
                                        console.log(response)
                                        self2.close()
                                        return false
                                    }).fail(function(){
                                        self2.close()
                                        toastr.error('Error, consulte con su administrador')
                                        return false
                                    })
                                }
                            })

                            //toastr.success('Bienvenido')
                            return false
                        }
                    },
                    Cancelar: function(){}
                }
            })
        })
        $('#cliente').autocomplete({
            serviceUrl: '{{ route("autocomplete-cliente") }}',
            minChars: 3,
            dataType: 'JSON',
            type: 'POST',
            paramName:'cliente',
            params: {
                cliente: $('#cliente').val(),
                _token:'{{ csrf_token() }}'
            },
            onSelect: function(suggestion){
                $('#id_cliente').val(suggestion.data.id_persona)
            }
        })
    })
</script>
    
@endsection

