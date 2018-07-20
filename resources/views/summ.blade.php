@extends('mainBody')
@section('section')
	<input type="text" class="input1" value="{{ $summC1 }} + {{ $summC2 }}" style="text-align: center;" readonly>
	<form class="inputSection" action="/larKurs/triger/summ" method="get">
		<input type="number" name="summ" class="input1" placeholder="Введи сумму {{ $summC1 }} и {{ $summC2 }}">
		<br>
		<input type="submit" class="button1" value="Next">
	</form>
@endsection