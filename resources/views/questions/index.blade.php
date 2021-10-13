@extends('layouts.default')

@section('title')
{{ __('Questions') }}
<a href="{{ route('questions.create') }}" class="btn btn-outline-primary btn-sm">{{ __('New Question') }}</a>
@endsection

@section('content')

<x-alert />
<x-message type="warning">
    <x-slot name="title">
        {{ __('app.message_title') }}
    </x-slot>
    <p>{{ __('These credentials do not match our records.') }}</p>
</x-message>

@foreach($questions as $question)
<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title"><a href="{{ route('questions.show', $question->id) }}">{{ $question->title }}</a></h5>
        <div class="text-muted mb-4">
            @lang('Asked'): {{ $question->created_at->diffForHumans() }},
            {{ trans('By') }}: {{ $question->user->name }},
            {{ __('Answers') }}: {{ $question->answers_count }}
        </div>
        <p class="card-text">{{ Str::words($question->description, 30) }}</p>
        <div>Tags: {{ implode(', ', $question->tags->pluck('name')->toArray()) }}</div>
    </div>
    @can('update', $question)
    <div class="card-footer">
        <div class="d-flex justify-content-between">
            <div>
                <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-outline-dark">Edit</a>
            </div>
            <form action="{{ route('questions.destroy', $question->id) }}" method="post">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
            </form>
        </div>
    </div>
    @endcan
</div>
@endforeach

{{ $questions->withQueryString()->links() }}

@endsection