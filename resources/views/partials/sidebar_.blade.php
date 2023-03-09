@inject('request', 'Illuminate\Http\Request')

<aside class="main-sidebar elevation-4 sidebar-no-expand sidebar-dark-info">

    <a href="{{ url('/admin/home') }}" class="brand-link">

        <img src="{{ asset('adminlte3/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light">SIMED</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if (empty(Auth::user()->foto))
                    <img src="{{ asset('/img/avatar_plusis.png') }}" class="img-circle elevation-2" alt="User Image">
                @else
                    <img src="{{ asset('/storage/USUARIOS/') . '/' . Auth::user()->foto }}"
                        class="img-circle elevation-2" alt="User Image">
                @endif
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-compact nav-child-indent" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-header">MENU</li>
                @foreach ($menus as $key => $item)
                    @if ($item['parent'] != 0)
                    @break
                @endif
                @include('partials.menu-item_', ['item' => $item])
            @endforeach
        </ul>
    </nav>
</div>



</aside>
