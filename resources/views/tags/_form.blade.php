@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $message)
        <li>{{ $message }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ $action }}" method="post">
    {{--
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    {{ csrf_field() }}
    --}}
    @csrf
    @if($update)
    @method('put')
    @endif

    <div class="form-group mb-3">
        <label for="name">Tag Name:</label>
        <div class="mt-2">
            <input type="text" name="name" value="{{ old('name', $tag->name) }}" class="form-control @error('name') is-invalid @enderror">
            @error('name')
            <p class="invalid-feedback">{{ $message }}</p>
            @enderror
        </div>
        <div class="mt-2">
            <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $tag->description) }}</textarea>
            @error('description')
            <p class="invalid-feedback">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>