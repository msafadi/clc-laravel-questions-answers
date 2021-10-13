<x-dashboard-layout>

    <x-slot name="title">
        Tags
        <a class="btn btn-outline-dark btn-xs" href="/tags/create">Add New</a>
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item">Tags</li>
    </x-slot>

    <x-alert />

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($tags as $tag)
            <tr>
                <td>{{ $tag->id }}</td>
                <td><a href="/tags/{{ $tag->id }}/edit">{{ $tag->name }}</a></td>
                <td>{{ $tag->slug }}</td>
                <td>{{ $tag->created_at }}</td>
                <td>{{ $tag->updated_at }}</td>
                <td>
                    <form class="delete-form" action="/tags/{{ $tag->id }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        setTimeout(function() {
            document.querySelector('.alert').style.display = "none"
        }, 5000)

        document.querySelector('.delete-form').addEventListener('submit', function(e) {
            e.preventDefault();
            if (confirm("Are you sure you want to delete this item?")) {
                e.target.submit();
            }
        })
    </script>

</x-dashboard-layout>