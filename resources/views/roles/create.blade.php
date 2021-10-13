<x-dashboard-layout>

    <x-slot name="title">
        Create Role
        <a class="btn btn-outline-dark btn-xs" href="{{ route('roles.create') }}">Add New</a>
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item">Roles</li>
    </x-slot>

    <x-alert />

    @include('roles._form', [
    'action' => route('roles.store'),
    'update' => false
    ])

</x-dashboard-layout>