@extends(config('xacl.view.extends'))

@section(config('xacl.view.section'))

    <div class="row">

        <div class="col-xs-12">

            <div class="x_panel">
                <div class="x_content">

                    <div class="x_body">

                        @include('xacl::messages')

                        <form action="{!! route('xacl.store') !!}" method="POST" class="xacl-form">

                            @csrf

                            @php

                                $countGroups = $groups->count();
                                if($countGroups < 1) $countGroups = 1;

                                $collumnWidth = (string)(80 / $countGroups) . '%';

                            @endphp

                            @if($groups->isEmpty())
                                <div class="alert alert-danger">
                                    {{ __('No groups registered') }}
                                    <a style="color: #fff;" href="{{ route('xacl.groups') }}">
                                        <b>{{ __('Register here') }}</b>
                                    </a>
                                </div>
                            @endif

                            @foreach($modules as $module)

                                <div class="module-item">

                                    <div class="alert alert-info">
                                        <h4>
                                            {{ $module->getDoc('class') }}
                                        </h4>
                                        <small>{{ $module->getNameSpaceName() }}</small>

                                    </div>

                                    <div class="table-responsive">

                                        <table class="table table-bordered table-hover table-striped">

                                            <thead>
                                                <tr>
                                                    <th width="20%"></th>
                                                    @foreach($groups as $group)

                                                        <th width="{{ $collumnWidth }}">

                                                            <span>{{ $group->name }}</span>

                                                            <button
                                                                style="display: inline-block;"
                                                                class="btn btn-success btn-select-all-xacl select-all"
                                                                data-id="{{ $group->id }}">&nbsp</button>

                                                            <button
                                                                style="display: inline-block;"
                                                                class="btn btn-danger btn-select-all-xacl unselect-all"
                                                                data-id="{{ $group->id }}">&nbsp</button>
                                                        </th>

                                                    @endforeach
                                                </tr>
                                            </thead>

                                            <tbody>

                                                @foreach($module->getMethods() as $method)

                                                    <tr>

                                                        <td width="20%">{{ $module->getDoc($method) }}</td>

                                                        @foreach($groups as $group)
                                                            <td width="{{ $collumnWidth }}">
                                                                <input
                                                                    type="checkbox"
                                                                    name="permissions[]"
                                                                    value="{{ \XACL::getInputvalue($group, $module, $method) }}"
                                                                    class="gid-{{ $group->id }}"
                                                                    {{ \XACL::getChecked($group, $module, $method) }}>
                                                            </td>
                                                        @endforeach

                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                            @endforeach

                            <div class="form-group">
                                <button type="submit" class="btn btn-success">{{ __('Save') }}</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
