@extends('layout')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 m-5">
            <a href="{{route('create')}}" class="btn btn-primary mb-4">NOVO</a>
            <table class="table table-striped">
                <thead>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Ação</th>
                </thead>
                <tbody>
                    @if(isset($users))
                    @foreach($users as $value)
                    <tr>
                        <td>{{$value->name}}</td>
                        <td>{{$value->email}}</td>
                        <td>{{$value->phone}}</td>
                        <td>
                            <a href="{{route('edit', $value->id)}}" class="btn btn-info">EDITAR</a>
                            <a href="{{route('delete', $value->id)}}" class="btn btn-danger">EXCLUIR</a>
                        </td>
                        
                    </tr>
                    @endforeach
                    @endif
                    
                   
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {!! $users->links() !!}
            </div>
        </div>
    </div>
</div>
@endsection