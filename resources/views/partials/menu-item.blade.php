@if ($item['submenu'] == [])
					<li>
                        <a href="{{ url($item['slug']) }}">
                            <i class="fa fa-briefcase"></i>
                            <span class="title">

                                {{ strtoupper($item['name']) }}
                            </span>
                        </a>
                    </li>
@else

 <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span class="title">{{ strtoupper($item['name']) }}</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
			@foreach ($item['submenu'] as $submenu)
                @if ($submenu['submenu'] == [])

					<li>
                        <a href="{{ url($submenu['slug']) }}">
                            <i class="fa fa-briefcase" ></i>
                            <span class="title">
                                {{ strtoupper($submenu['name']) }}
                            </span>
                        </a>
                    </li>
                @else
                    @include('partials.menu-item', [ 'item' => $submenu ])
                @endif
            @endforeach

                </ul>
            </li>

@endif