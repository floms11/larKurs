@extends('mainBody')
@section('section')
	<p>Какой сегодня день недели?</p>
	<form class="inputSection" action="/larKurs/triger/days">
		<div class="checkList">
			@foreach($days as $day)
				<input type="radio" name="value" class="checkbox" value="{{ $day }}" value="php">{{ $daysText[$day] }}<br>
			@endforeach
		</div>
		<input type="submit" class="button1" value="Next">
	</form>
@endsection