@foreach($empresa->contas as $conta)
{{$conta->banco}} : {{$conta->numero}} <br>
@endforeach