@extends('layouts.default')

@section('title')
{{ trans('Questions') }}
<a href="{{ route('questions.create') }}" class="btn btn-outline-primary btn-sm">New Question</a>
@endsection

@section('content')

<x-alert />

<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title">{{ $question->title }}</h5>
        <div class="text-muted mb-4">
            @lang('Asked'): {{ $question->created_at->diffForHumans() }}, By: {{ $question->user->name }}
        </div>
        <p class="card-text">{{ $question->description }}</p>
        <div>
            {{ __('Tags') }}
            <ul class="inline-list">
                @foreach($question->tags as $tag)
                <li><span class="">{{ $tag->name }}</span></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<section>
    <h3>{{ $answers->count() }} Answers</h3>
    @forelse ($answers as $answer)
    <div class="card mb-3">
        <div class="card-body">
            @if($answer->best_answer == 1)
            <span class="badge bg-success">BEST</span>
            @endif
            <p class="card-text">{{ $answer->description }}</p>
            <div class="text-muted mb-4">
                {{ $answer->created_at->diffForHumans() }},
                By: {{ $answer->user->name }}
            </div>
            @auth
            @if($answer->best_answer == 0 && Auth::id() == $question->user_id)
            <form action="{{ route('answers.best', $answer->id) }}" method="post">
                @csrf
                @method('put')
                <button type="submit" class="btn btn-success">Mark as best answer</button>
            </form>
            @endif
            @endauth
        </div>
    </div>
    @empty
    <div class="mb-3">
        <p class="">No answers!</p>
    </div>
    @endforelse
    @auth
    <hr>
    <h4>Send Your Answer</h4>
    <form action="{{ route('answers.store') }}" method="post">
        @csrf
        <input type="hidden" name="question_id" value="{{ $question->id }}">
        <div class="form-group mb-3">
            <div>
                <textarea class="form-control @error('description') is-invalid @enderror" rows="6" name="description">{{ old('description') }}</textarea>
                @error('description')
                <p class="invalid-feedback">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Submit Answer</button>
        </div>
    </form>
    @endauth
    @guest
    <a href="{{ route('login') }}">Login to answer!</a>
    @endguest
</section>

@endsection