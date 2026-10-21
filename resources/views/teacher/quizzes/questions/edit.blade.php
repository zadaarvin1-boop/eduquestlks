@extends('teacher.quizzes.layout')

@section('title', 'Edit Soal - EduQuest')

@section('content')
    @include('teacher.quizzes.questions._form', [
        'quiz' => $quiz,
        'question' => $question,
        'action' => route('teacher.quizzes.questions.update', [$quiz, $question]),
    ])
@endsection