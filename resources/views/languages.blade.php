@extends('mainBody')
@section('section')
	<p>Какие языки программирования ты знаешь?</p>
	<form class="inputSection" action="/larKurs/triger/languages">
		<div class="checkList">
			<input type="checkbox" class="checkbox" name="v1" value="php">PHP<br>
			<input type="checkbox" class="checkbox" name="v2" value="python">Python<br>
			<input type="checkbox" class="checkbox" name="v3" value="js">JS<br>
			<input type="checkbox" class="checkbox" name="v4" value="net">.net<br>
			<input type="checkbox" class="checkbox" name="v5" value="vb">Visual Basic<br>
		</div>
		<input type="submit" class="button1" value="Next">
	</form>
@endsection