@extends('mainBody')
@section('section')
    @if (count($errors) > 0)
      <div class="erShow">
          @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
          @endforeach
      </div>
    @endif
	<form class="inputSection" action="larKurs/triger/" method="get">
		<input type="text" name="name" class="input1" placeholder="Введи своё имя" required>
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