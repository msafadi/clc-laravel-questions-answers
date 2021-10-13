@extends('layouts.default')

@section('title', 'New Question')

@section('content')

<form action="{{ route('questions.store') }}" method="post">
    @csrf
    <div class="form-group mb-3">
        <x-form-input type="text" class="form-control-lg" id="title" name="title" label="Question Title" />
    </div>
    <div class="form-group mb-3">
        <x-form-textarea name="description" id="description" label="Description" />
    </div>
    <div class="form-group mb-3">
        <label for="">Tags</label>
        <div>
            @foreach($tags as $tag)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="tags[]" value="{{ $tag->id }}" id="{{ $tag->id }}">
                <label class="form-check-label" for="tag-{{ $tag->id }}">
                    {{ $tag->name }}
                </label>
            </div>
            @endforeach
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Ask Question</button>
    </div>
</form>

@endsection