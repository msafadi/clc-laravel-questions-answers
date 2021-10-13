<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        @foreach ($items as $item)
        @if(!isset($item['ability']) || $user->can($item['ability'][0], $item['ability'][1]))
        <li class="nav-item">
            <a href="{{ route($item['route']) }}" class="nav-link">
                <i class="nav-icon {{ $item['icon'] }}"></i>
                <p>
                    {{ $item['title'] }}
                </p>
            </a>
        </li>
        @endif
        @endforeach
    </ul>
</nav>
<!-- /.sidebar-menu -->