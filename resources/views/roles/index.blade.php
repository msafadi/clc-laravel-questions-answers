<x-dashboard-layout>

    <x-slot name="title">
        Roles
        <a class="btn btn-outline-dark btn-xs" href="{{ route('roles.create') }}">Add New</a>
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item">Roles</li>
    </x-slot>

    <x-alert />

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $role)
            <tr>
                <td>{{ $role->id }}</td>
                <td><a href="{{ route('roles.edit', $role->id) }}">{{ $role->name }}</a></td>
                <td>{{ $role->created_at }}</td>
                <td>{{ $role->updated_at }}</td>
                <td>
                    <form class="delete-form" action="{{ route('roles.destroy', $role->id) }}" method="post">
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