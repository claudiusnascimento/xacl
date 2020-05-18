@extends(config('xacl.view.extends'))

@section(config('xacl.view.section'))

    <div class="row">

        <div class="col-xs-12">

            <div class="x_panel">
                <div class="x_content">

                    @include('xacl::messages')

                    <div class="text-right">
                        <a href="{{ route('xacl.actions') }}" class="btn btn-info">{{ __('Cancel') }}</a>
                    </div>

                    <div class="x_body">

                        <h3>{{ __('Edit action') }}</h3>

                        <form
                            action="{{ route('xacl.actions.update', $action->id) }}"
                            enctype="multipart/form-data"
                            method="POST">

                            <div class="row">
                                <div class="col-sm-8">

                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="form-group">
                                        <label for="action">{{ __('Action name') }}</label>
                                        <input type="text" name="action" value="{{ old('name', $action->action) }}" class="form-control">


                                        @if($errors->action->has('action'))
                                            <div class="validator-error"><small>{{ $errors->action->first('action') }}</small></div>
                                        @endif

                                    </div>

                                    <div class="form-group">
                                        <label for="description">{{ __('Action description') }}</label>
                                        <textarea type="text" name="description" class="form-control">{{ old('description', $action->description) }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="order">{{ __('Order') }}</label>
                                        <input style="width: 50px;" type="text" name="order" value="{{ old('order', $action->order) }}" class="form-control">
                                    </div>

                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="active" {{ old('active', $action->active) ? 'checked' : '' }} value="1"> {{ __('Active') }}
                                        </label>
                                    </div>

                                    <div class="form-group text-right">
                                        <button class="btn btn-success">{{ __('Save') }}</button>
                                    </div>

                                </div>

                                <div class="col-xs-4">

                                    <h4><b>{{ __('Groups') }}</b></h4>
                                    <ul>
                                        @foreach($groups as $group)
                                            <li>
                                                <label>
                                                    <input
                                                        type="checkbox"
                                                        name="groups[]"
                                                        value="{{ $group->id }}"
                                                        {{ in_array($group->id, old('groups', $action->groups->pluck('id')->toArray())) ? ' checked' : '' }}> {{ $group->name }}
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
