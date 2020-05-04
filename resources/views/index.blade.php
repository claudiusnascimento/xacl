@extends(config('xacl.view.extends'))

@section(config('xacl.view.section'))

    <div class="row">

        <div class="col-xs-12">

            <div class="x_panel">
                <div class="x_content">

                    <div class="x_body">

                        <form action="" class="xacl-form">

                            @php

                                $countGroups = $groups->count();

                                $collumnWidth = (string)(80 / $countGroups) . '%';

                            @endphp

                            @foreach($modules as $module)

                                <div class="module-item">

                                    <div class="alert alert-info">
                                        <h4>
                                            {{ $module->getDoc('class') }}
                                            <small>{{ $module->getNameSpaceName() }}</small>
                                        </h4>

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
                                                                    value="gid|{{ $group->id . '|' . $module->class . '@' . $method }}"
                                                                    class="gid-{{ $group->id }}">
                                                            </td>
                                                        @endforeach

                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                            @endforeach



                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
