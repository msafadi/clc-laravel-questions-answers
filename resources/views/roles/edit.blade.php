<x-dashboard-layout>

    <x-slot name="title">
        Edit Role
        <a class="btn btn-outline-dark btn-xs" href="{{ route('roles.create') }}">Add New</a>
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item">Roles</li>
    </x-slot>

    <x-alert />

    @include('roles._form', [
    'action' => route('roles.update', $role->id),
    'update' => true
    ])
</x-dashboard-layout>