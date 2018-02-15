@extends('layouts.master')
@section('content')

    
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Produto</th>
                <th>Preço</th>
                <th>Quantidade</th>
                <th>Desconto</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($facturas as $key => $saidas)
            <tr>
                <td>{{$saidas->id}}</td>
                <td>{{$saidas->produto_id}}</td>
                <td>{{$saidas->preco_venda}}</td>
                <td>{{$saidas->quantidade}}</td>
                <td>{{$saidas->desconto}}</td>
                <td>{{$saidas->subtotal}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <hr>

    <table class="table">
            <thead>
                <tr>
                    
                    <th>Produto</th>
                    <th>Preço</th>
                    <th>Quantidade</th>
                    
                </tr>
            </thead>
            <tbody>
                <tr>
                    
                    <td>{{$dados['descricao']}}</td>
                    <td>{{$dados['quantidade']}}</td>
                    <td>{{$dados['preco_venda']}}</td>
                    
                </tr>
            </tbody>
        </table>


@endsection