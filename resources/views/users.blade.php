@extends(config('xacl.view.extends'))

@section(config('xacl.view.section'))

    <div class="row">

        <div class="col-xs-12">

            <div class="x_panel">
                <div class="x_content">

                    <div class="x_body">

                        @php
                            $width = 100 / (2 + $groups->count()) . '%';
                        @endphp

                        @include('xacl::messages')
                        <br>
                        @include('xacl::errors')

                        @foreach($users as $user)
                            <div class="table-responsive" style="overflow-y: hidden;">

                                <form method="POST" action="{{ route('xacl.users.add.group', $user->id) }}">

                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_bag" value="{{ 'user-' . $user->id }}">

                                    <table class="table table-striped text-center xacl-users-table">
                                        <thead>
                                            <tr class="headings">
                                                <th width="{{ $width }}"></th>

                                                @foreach($groups as $group)
                                                    <th width="{{ $width }}" class="text-center">
                                                        {{ $group->name }}
                                                    </th>
                                                @endforeach

                                                <th width="{{ $width }}"></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr class="text-center">
                                                <td width="{{ $width }}">
                                                    <span>{{ $user->name }}</span> <br>
                                                    <small>{{ $user->email }}</small>
                                                </td>

                                                @foreach($groups as $group)
                                                    <td width="{{ $width }}"><input name="groups[]" value="{{ $group->id }}" {{ $user->getGroupChecked($group) }} type="checkbox"></td>
                                                @endforeach

                                                <td width="{{ $width }}">
                                                    <button type="submit" class="btn btn-info">Salvar</button>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </form>
                            </div>

                            @include('xacl::errors')

                            <br>

                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
