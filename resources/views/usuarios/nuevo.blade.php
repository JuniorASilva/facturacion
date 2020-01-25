@extends('body/body')
@section('contenido')
    <main class="main-content p-5" role="main">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h2> {{ isset($usuario)?'Actualizacion de Usuario':'Nuevo Usuario' }}</h2>
                        @if (session()->get('message_insert'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                {{ session()->get('message_insert') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                        @endif
                        <form method="POST" id="registro-usuario">
                            <div class="form-group row">
                                <label for="nombres" class="col-sm-2 col-form-label">Nombres*</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="nombres" required name="nombres" placeholder="Nombres" value="<?= !isset($usuario) ? '':$usuario->nombres ?>">
                                </div>
                                <label for="apellidos" class="col-sm-2 col-form-label">Apellidos*</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="apellidos" required name="apellidos" placeholder="Apellidos" value="<?= !isset($usuario) ? '':$usuario->apellidos ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="usuario" class="col-sm-2 col-form-label">Usuario*</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="usuario" required name="usuario" placeholder="Usuario" value="<?= !isset($usuario) ? '':$usuario->usuario ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="pass" class="col-sm-2 col-form-label">Contraseña*</label>
                                <div class="col-sm-4">
                                    <input type="password" class="form-control" id="pass" name="pass" {{ <?= isset($usuario)?'':'required' ?> }} placeholder="Contraseña">
                                </div>
                                <label for="repeat-pass" class="col-sm-2 col-form-label">Contraseña*</label>
                                <div class="col-sm-4">
                                    <input type="password" class="form-control" id="repeat-pass" name="repeat-pass" {{ <?= isset($usuario)?'':'required' ?> }} placeholder="Repetir Contraseña">
                                </div>
                            </div>
                            <fieldset class="form-group">
                                <div class="row">
                                    <legend class="col-form-label col-sm-2 pt-0">Roles</legend>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="roles" required name="roles">
                                            @foreach ($roles as $rol)
                                                <option value="{{ $rol->id }}" {{ isset($usuario) && $usuario->id_rol==$rol->id ? '': 'selected' }}> {{ $rol->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="form-group row">
                                <div class="col-sm-2">Checkbox</div>
                                <div class="col-sm-10">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="gridCheck1">
                                        <label class="form-check-label" for="gridCheck1">
                                            Example checkbox
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary"><?= !isset($usuario)?'Registrar':'Actualizar' ?> </button>
                                </div>
                            </div>
                            @csrf
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </main>
    <script type="text/javascript">
        
        $(function(){
            $('#registro-usuario').on('submit',function(){
                event.preventDefault()
                //toastr.error('Este es un mensaje de prueba')
                $.confirm({
                    content: function(){
                        var self = this
                        return $.ajax({
                            url:"{{ route('editar-usuario',['id'=>isset($usuario)?$usuario->id:0]) }}",
                            method : 'POST',
                            dataType: 'JSON',
                            data: $('#registro-usuario').serialize()
                        }).done(function(response){
                            self.close()
                            toastr.success(response.message)
                            setTimeout(function(){
                                window.location.href='{{ route("usuarios") }}'
                            },3000)
                        }).fail(function(){
                            self.close()
                            toastr.error('Error, consulte con su administrador')
                        })
                    }
                })
            })
            $('#usuario').on('blur',function(){
                if($('#usuario').val()=='')
                    return false
                $.ajax({
                    url:'{{ route("consulta-usuario") }}',
                    method:'POST',
                    dataType:'JSON',
                    data: {
                        usuario: $('#usuario').val(),
                        _token: '{{ Csrf_token() }}'
                    }
                }).done(function(response){
                    if(response.status==202)
                        {
                            $('#registrar').attr('disabled','disabled')
                            $('#usuario').addClass('border-danger').removeClass('border-success')
                        }
                    else
                        {
                            $('#registrar').removeAttr('disabled')
                            $('#usuario').addClass('border-success').removeClass('border-danger')
                        }
                    console.log(response)
                    setTimeout(function(){
                        $('#usuario').removeClass('border-success')
                    },3000);
                }).fail(function(){})
            })
        })
    </script>
    <script type=”text/javascript”>
        setInterval(function(){
              document.getElementById('').innerHTML = new Date();
        },1000);
  </script>
@endsection