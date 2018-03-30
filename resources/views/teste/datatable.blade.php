@extends('layouts.master')
@section('content')
    
    
<table id="users-table" class="table">
    <thead>
        <th>#</th>
        <th>Descrição</th>
        <th>Preço de Venda</th>
        <th>Preço de Aquisição</th>
        <th>Quantidade Disponivel</th>
    </thead>
</table>       



    <script type="text/javascript">
            $(function() {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: 'http://localhost:8000/table/dados',
                columns: [
                {data:  'id'},
                {data:  'descricao'},
                {data: 'preco_venda'},
                {data: 'preco_aquisicao'},
                {data: 'quantidade_dispo'}
            ]
            });
        });
    </script>
@endsection