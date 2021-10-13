@extends('layouts.default')

@section('title', 'New Question')

@section('content')

<form action="{{ route('questions.update', $question->id) }}" method="post">
    @csrf
    @method('put')
    <div class="form-group mb-3">
        <x-form-input :value="$question->title" class="form-control-lg" id="title" name="title" label="Question Title" />
    </div>
    <div class="form-group mb-3">
        <x-form-textarea :value="$question->description" name="description" id="description" label="Description" />
    </div>
    <div class="form-group mb-3">
        <label for="">Tags</label>
        <div>
            @foreach($tags as $tag)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="tags[]" value="{{ $tag->id }}" id="{{ $tag->id }}" @if(in_array($tag->id, $question_tags)) checked @endif>
                <label class="form-check-label" for="tag-{{ $tag->id }}">
                    {{ $tag->name }}
                </label>
            </div>
            @endforeach
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Update Question</button>
    </div>
</form>

@endsection