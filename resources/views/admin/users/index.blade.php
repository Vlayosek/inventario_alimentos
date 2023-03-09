@extends('layouts.app_')

@section('descripcion_detalle')
    USUARIOS / LISTADO USUARIOS
@endsection

@section('css')
    <style>
        label {
            font-size: 12px !important;
        }

        .nav-item {
            font-size: 12px;
        }
    </style>
@endsection

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-info btn-xs"><i
                            class="fa fa-plus"></i>&nbsp;Agregar Nuevo Usuario</a>
                </div>
            </div>
            <div class="card-body">
                <table
                    class="table table-bordered table-striped table-hover {{ count($users) > 0 ? 'datatable' : '' }} dt-select"
                    style="width:100%!important" id="tbUsers">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Nombre Completo</th>
                            <th>Correo</th>
                            <th>@lang('global.users.fields.roles')</th>
                            <th>Estado</th>
                            <th class="hidden">Tipo</th>
                            <th></th>
                            {{-- <th>&nbsp;</th> --}}
                        </tr>
                    </thead>

                    <tbody>
                        @if (count($users) > 0)
                            @foreach ($users as $user)
                                <tr data-entry-id="{{ $user->id }}">
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->nombreCompleto }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @foreach ($user->roles()->pluck('name') as $role)
                                            <span class="label label-info label-many">{{ $role }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        @if ($user->estado == 'A')
                                            <span class="badge bg-success">Activo</span>
                                        @endif
                                        @if ($user->estado == 'I')
                                            <span class="badge bg-danger">Inactivo</span>
                                        @endif
                                    </td>
                                    <td class="hidden">
                                        @foreach ($user->tipoUsuario()->pluck('descripcion') as $key => $value)
                                            {{ $value }}
                                        @endforeach
                                    </td>
                                    {{-- <td>
                                        <a href="{{ route('admin.users.edit', [$user->id]) }}"
                                            class="btn btn-xs btn-info btn-block">@lang('global.app_edit')</a>

                                        <a href="{{ route('admin.userstate', [$user->id]) }}"
                                            class="btn btn-xs btn-warning btn-block"><i class="fa fa-sync"></i></a>
                                        <a href="{{ route('impersonate', $user->id) }}"
                                            class="btn btn-xs btn-default btn-block">
                                            Impersonate
                                        </a>
                                    </td> --}}
                                    <td>
                                        <table style="width: 100%">
                                            <tr>
                                                <td> <a href="{{ route('admin.users.edit', [$user->id]) }}"
                                                        class="btn btn-xs btn-info">@lang('global.app_edit')</a>
                                                    {!! Form::open([
                                                        'style' => 'display:none;',
                                                        'method' => 'DELETE',
                                                        'onsubmit' => "return confirm('" . trans('global.app_are_you_sure') . "');",
                                                        'route' => ['admin.users.destroy', $user->id],
                                                    ]) !!}
                                                    {!! Form::submit('Borrar', ['class' => 'btn btn-xs btn-danger']) !!}
                                                    {!! Form::close() !!}</td>
                                                <td>
                                                    <a href="{{ route('admin.userstate', [$user->id]) }}"
                                                        class="btn btn-xs btn-warning"><i class="fa fa-sync"></i></a>
                                                </td>
                                                <td>
                                                    <a href="{{ route('impersonate', $user->id) }}"
                                                        class="btn btn-xs btn-default btn-block">
                                                        Impersonate
                                                    </a>
                                                </td>
                                            </tr>

                                        </table>
                                    </td>
                                    {{--  <td>
                                        <a href="{{ route('impersonate', $user->id) }}"
                                            class="btn btn-xs btn-default btn-block">
                                            Impersonate
                                        </a>
                                    </td> --}}


                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7">@lang('global.app_no_entries_in_table')</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script src="{{ asset('js/modules/admin/users.js?v=1') }}"></script>
    <script src="{{ asset('adminlte3/plugins/sweetAlert/SWA.js') }}"></script>

    <script>
        @if (isset($m))
            swal("{{ $m }}", '', "warning");
        @endif
        window.route_mass_crud_entries_destroy = '{{ route('admin.users.mass_destroy') }}';
    </script>
@endsection
