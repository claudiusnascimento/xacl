@extends(config('xacl.view.extends'))

@section(config('xacl.view.section'))

    <div class="row">

        <div class="col-xs-12">

            <div class="x_panel">
                <div class="x_content">

                    @include('xacl::messages')

                    <div class="text-right">
                        <a href="{{ route('xacl.groups') }}" class="btn btn-info">{{ __('Cancel') }}</a>
                    </div>

                    <div class="x_body">

                        <h3>{{ __('Edit Group') }}</h3>

                        <form
                            action="{{ route('xacl.groups.update', $group->id) }}"
                            enctype="multipart/form-data"
                            method="POST">

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label for="name">Nome do grupo</label>
                                <input type="text" name="name" value="{{ old('name', $group->name) }}" class="form-control">


                                @if($errors->group->has('name'))
                                    <div class="validator-error"><small>{{ $errors->group->first('name') }}</small></div>
                                @endif

                            </div>

                            <div class="form-group">
                                <label for="description">{{ __('Group description') }}</label>
                                <textarea type="text" name="description" class="form-control">{{ old('description', $group->description) }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="order">Ordem</label>
                                <input style="width: 50px;" type="text" name="order" value="{{ old('order', $group->order) }}" class="form-control">
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="active" {{ old('active', $group->active) ? 'checked' : '' }} value="1"> {{ __('Active') }}
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
