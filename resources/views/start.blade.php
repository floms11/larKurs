@extends('mainBody')
@section('section')
	<form class="inputSection" action="larKurs/triger/">
		<input type="text" name="name" class="input1" placeholder="Введи своё имя">
		<input type="submit" class="button1" value="Next">
	</form>
	<p>Результаты предыдущих 10 прохождений:</p>
	<table class="listKurs">
		<tr>
			<th>Имя</th>
			<th>Количество баллов</th>
			<th>Затрачено времени</th>
		</tr>
		@foreach($list as $res)
		<tr>
			<td>{{ $res->name }}</td>
			<td>{{ $res->result }}</td>
			<td>{{ $res->endTime - $res->startTime }} сек.</td>
		</tr>
		@endforeach
	</table>
@endsection