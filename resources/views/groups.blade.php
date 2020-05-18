@extends(config('xacl.view.extends'))

@section(config('xacl.view.section'))

    <div class="row">

        <div class="col-xs-12">

            <div class="x_panel">
                <div class="x_content">

                    @include('xacl::messages')

                    <div class="x_body">

                        @foreach($groups as $group)

                            <div class="xacl-box clearfix">
                                <h3>{{ $group->name }}</h3>
                                <p>{{ empty(trim(strip_tags($group->description))) ? 'Sem descrição' : $group->description }}</p>
                                <div class="div">
                                    <h5>{{ $group->active ? __('Active') : __('Inactive') }}</h5>
                                </div>

                                <form
                                    class="delete-group-form pull-left"
                                    action="{{ route('xacl.groups.delete', $group->id) }}"
                                    enctype="multipart/form-data"
                                    method="POST">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button type="submit" class="btn btn-danger md btn-delete-group">{{ __('Delete group') }}</button>
                                </form>

                                <a href="{{ route('xacl.groups.edit', $group->id) }}" class="btn btn-success md">Editar grupo</a>
                                <br>
                            </div>

                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-xs-12">

            <div class="x_panel">
                <div class="x_content">

                    <div class="x_body">

                        <h3>{{ __('Store new group') }}</h3>

                        <form
                            action="{{ route('xacl.groups.store') }}"
                            enctype="multipart/form-data"
                            method="POST">

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label for="name">{{ __('Group name') }}</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control">


                                @if($errors->group->has('name'))
                                    <div class="validator-error"><small>{{ $errors->group->first('name') }}</small></div>
                                @endif

                            </div>

                            <div class="form-group">
                                <label for="description">{{ __('Group description') }}</label>
                                <textarea type="text" name="description" class="form-control">{{ old('description') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="order">{{ __('Order') }}</label>
                                <input style="width: 50px;" type="text" name="order" value="{{ old('order') }}" class="form-control">
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="active" {{ old('active') ? 'checked' : '' }} value="1"> {{ __('Active') }}
                                </label>
                            </div>

                            <div class="form-group text-right">
                                <button class="btn btn-success">{{ __('Save') }}</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
