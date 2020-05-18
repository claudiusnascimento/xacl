@extends(config('xacl.view.extends'))

@section(config('xacl.view.section'))

    <div class="row">

        <div class="col-xs-12">

            <div class="x_panel">
                <div class="x_content">

                    @include('xacl::messages')

                    <div class="x_body">

                        @foreach($actions as $action)

                            <div class="xacl-box clearfix">
                                <h3>{{ $action->action }}</h3>
                                <p>{{ empty(trim(strip_tags($action->description))) ? __('No description') : $action->description }}</p>
                                <div class="div">
                                    <h5>{{ $action->active ? __('Active') : __('Inactive') }}</h5>
                                </div>

                                @if($action->groups->isNotEmpty())

                                    <div class="action-groups">
                                        <h4 class="label-groups">{{ __('Groups with access to this action') }}: </h4>
                                        <div class="groups-list">
                                            @foreach($action->groups as $g)
                                                <span>{{ $g->name }}</span>&nbsp;
                                            @endforeach
                                        </div>
                                    </div>

                                @endif

                                <form
                                    class="delete-group-form pull-left"
                                    action="{{ route('xacl.actions.delete', $action->id) }}"
                                    enctype="multipart/form-data"
                                    method="POST">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button type="submit" class="btn btn-danger md btn-delete-action">{{ __('Delete action') }}</button>
                                </form>

                                <a href="{{ route('xacl.actions.edit', $action->id) }}" class="btn btn-success md">{{ __('Edit action') }}</a>
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

                        <h3>{{ __('Store new action') }}</h3>

                        <form
                            action="{{ route('xacl.actions.store') }}"
                            enctype="multipart/form-data"
                            method="POST">

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="action">{{ __('Action name') }}</label>
                                        <input type="text" name="action" value="{{ old('action') }}" class="form-control">

                                        @if($errors->action->has('action'))
                                            <div class="validator-error"><small>{{ $errors->action->first('action') }}</small></div>
                                        @endif

                                    </div>

                                    <div class="form-group">
                                        <label for="description">{{ __('Action description') }}</label>
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

                                </div>

                                <div class="col-xs-4">

                                    <h4><b>{{ __('Groups') }}</b></h4>

                                    <ul>
                                        @foreach($groups as $group)
                                            <li>
                                                <label>
                                                    <input type="checkbox" name="groups[]" value="{{ $group->id }}" {{ in_array($group->id, old('groups', [])) ? ' checked' : '' }}> {{ $group->name }}
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
