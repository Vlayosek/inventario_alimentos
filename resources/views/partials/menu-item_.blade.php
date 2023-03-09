@if ($item['submenu'] == [])
    <li class="nav-item">
        <a href="{{ url($item['slug']) }}" class="nav-link">
            <i class="fa fa-briefcase"></i>&nbsp;&nbsp;
            <p>
                {{ strtoupper($item['name']) }}
            </p>
        </a>
    </li>
@else
    <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="fa fa-tasks"></i>&nbsp;&nbsp;
            <p>{{ strtoupper($item['name']) }}</p>
            <span class="title"></span>
       
        </a>
        <ul class="nav nav-treeview">
            @foreach ($item['submenu'] as $submenu)
                @if ($submenu['submenu'] == [])
                    <li class="nav-item">
                        <a href="{{ url($submenu['slug']) }}" class="nav-link">
                            <i class="fa fa-tasks"></i>&nbsp;&nbsp;
                            <p>{{ strtoupper($submenu['name']) }}</p>
                        </a>
                    </li>
                @else
                    @include('partials.menu-item_', ['item' => $submenu])
                @endif
            @endforeach

        </ul>
    </li>

@endif
