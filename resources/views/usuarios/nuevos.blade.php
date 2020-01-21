@extends('body/body')
@section('contenido')
    <main class="main-content p-5" role="main">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div><h2>{{ isset($usuario)? 'Actualizacion de ' : 'Registro de '}}Usuario</h2></div>
                        <br>
                        @if (session()->get('message_insert'))
                        <div class="alert alert-primary alert-dismissible fade show">{{ session()->get('message_insert') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button></div>
                        @endif
                        <form method="post">
                            <div class="form-group row">
                                <label for="nombres" class="col-sm-2 col-form-label">Nombres</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" required id="nombres" name="nombres" placeholder="Nombres" value="<?= is_null($usuario)? '' : $usuario->nombres?>">
                                </div>
                                <label for="apellidos" class="col-sm-2 col-form-label">Apellidos</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" required id="apellidos" name="apellidos" placeholder="Apellidos" value="<?= is_null($usuario)? '' : $usuario->apellidos?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="usuario" class="col-sm-2 col-form-label">Usuario</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" required id="usuario" name="usuario" placeholder="Usuario" value="<?= is_null($usuario)? '' : $usuario->usuario?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="pass" class="col-sm-2 col-form-label">Contraseña</label>
                                <div class="col-sm-4">
                                    <input type="password" class="form-control" id="pass" required name="pass" placeholder="Contraseña">
                                </div>
                                <label for="repeat-pass" class="col-sm-2 col-form-label">Repetir Contraseña</label>
                                <div class="col-sm-4">
                                    <input type="password" class="form-control" id="repeat-pass" required name="repeat-pass" placeholder="Repetir Contraseña">
                                </div>
                            </div>
                            <fieldset class="form-group">
                                <div class="row">
                                    <legend class="col-form-label col-sm-2 pt-0">Roles</legend>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="roles" name="roles" required>
                                            @foreach ($roles as $rol)
                                                <option value="{{ $rol->id }}" {{ isset($usuario) && $usuario->rol_id == $rol->id ? '' : 'selected' }}> {{ $rol->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                            
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button type="submit" id="registrar" class="btn btn-primary">Sign in</button>
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
            $('#usuario').on('blur',function(){
                if($('#usuario').val() == '')
                    return false
                $.ajax({
                    url: '{{ route("consulta-usuario") }}',
                    method: 'POST',
                    dataType: 'JSON',
                    data:{
                        usuario: $('#usuario').val(),
                        _token: '{{ @csrf_token() }}'
                    }
                }).done(function(response){
                    if(response.status == 202){
                        $('#registrar').attr('disabled','disabled')
                        $('#usuario').addClass('border-danger').removeClass('border-success')
                        
                    }else{
                        $('#registrar').removeAttr('disabled')
                        $('#usuario').addClass('border-success').removeClass('border-danger')
                        setTimeout(()=>{
                            $('#usuario').removeClass('border-success')
                        },3000);
                    }
                    console.log(response)
                }).fail(function(){})
            })
        })
    </script>
@endsection