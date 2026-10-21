@extends('teacher.quizzes.layout')

@section('title', 'Tambah Soal - EduQuest')

@section('content')
    @include('teacher.quizzes.questions._form', [
        'quiz' => $quiz,
        'action' => route('teacher.quizzes.questions.store', $quiz),
    ])
@endsection