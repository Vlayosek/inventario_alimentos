@inject('request', 'Illuminate\Http\Request')
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar elevation-4">
    <!-- sidebar: style can be found in sidebar.less -->
    <div class="user-panel">
        <div class="pull-left image">
            @if (empty(Auth::user()->foto))
                <img src="{{ asset('/img/avatar_plusis.png') }}" class="img-circle" alt="User Image">
            @else
                <img src="{{ asset('/storage/USUARIOS/') . '/' . Auth::user()->foto }}" class="img-circle" alt="User Image">
            @endif



        </div>
        <div class="pull-left info">
            <span style="">{{ Auth::user()->name }}</span><br />
            <br />
        </div>
    </div>

    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="header">MENU</li>
            @foreach ($menus as $key => $item)
                @if ($item['parent'] != 0)
                @break
            @endif
            @include('partials.menu-item', ['item' => $item])
        @endforeach

    </ul>
</section>
</aside>
