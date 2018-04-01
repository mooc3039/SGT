{{$empresa->nome}}<hr>
{{$empresa->actuacao}}<br>

@foreach($empresa->emails as $email)
{{$email->email}} / 
@endforeach <br>

@foreach($empresa->telefones as $telefone)
{{$telefone->telefone}} / 
@endforeach <br>

@foreach($empresa->enderecos as $endereco)
{{$endereco->endereco}} / 
@endforeach