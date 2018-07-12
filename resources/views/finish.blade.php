<?php
	function getTextBal($bal) {
		switch($bal) {
			case 1:
				return 'балл';
			case 2:
			case 3:
			case 4:
				return 'балла';
			default:
				return 'баллов';
		}
	}
	function getTextSecond($second) {
		// Определяем последнюю цифру числа
		$endC = $second % 10;
		switch ($endC) {
			case 1:
				return 'секунда';
			case 2:
			case 3:
			case 4:
				return 'секунды';
			default:
				return 'секунд';
		}
	}
?>
@extends('mainBody')
@section('section')
	<p>Поздравляем, {{ $userData->name }}</p>
	<p>
		Твоя оценка {{ $userData->result . ' ' . getTextBal($userData->result) }}
	</p>
	<p>
		Общее время прохождения теста - {{ $userData->endTime - $userData->startTime . ' ' . getTextSecond($userData->endTime - $userData->startTime) }}
	</p>
	<a href="/larKurs/restart" class="button1">Перейти в начало</a>
@endsection