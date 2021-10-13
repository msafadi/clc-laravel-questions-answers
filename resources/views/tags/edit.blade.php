<x-dashboard-layout>

    <x-slot name="title">
        Edit Tag
        <a class="btn btn-outline-dark btn-xs" href="/tags/create">Add New</a>
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item">Tags</li>
    </x-slot>

    <x-alert />

    @include('tags._form', [
    'action' => '/tags/' . $tag->id,
    'update' => true
    ])

</x-dashboard-layout>