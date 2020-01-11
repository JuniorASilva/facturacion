@extends('body.body')

@section('contenido')
    <main class="main-content p-5" role="main">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nombres</th>
                                    <th scope="col">Usuario</th>
                                    <th scope="col">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($usuarios as $usuario)
                                    <tr>
                                        <td>{{$usuario->id}}</td>
                                        <td>{{$usuario->nombres}}</td>
                                        <td>{{$usuario->usuario}}</td>
                                        <td>{{$usuario->estado}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="row">
                            <a class="btn btn-outline-primary" href="{{ route('nuevo-usuario') }}">
                                Nuevo usuario
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection