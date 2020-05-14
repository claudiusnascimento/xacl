@extends(config('xacl.view.extends'))

@section(config('xacl.view.section'))

    <div class="row">

        <div class="col-xs-12">

            <div class="x_panel">
                <div class="x_content">

                    @include('xacl::messages')

                    <div class="text-right">
                        <a href="{{ route('xacl.actions') }}" class="btn btn-info">Cancelar</a>
                    </div>

                    <div class="x_body">

                        <h3>Editar ação</h3>

                        <form
                            action="{{ route('xacl.actions.update', $action->id) }}"
                            enctype="multipart/form-data"
                            method="POST">

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label for="action">Nome do ação</label>
                                <input type="text" name="action" value="{{ old('name', $action->action) }}" class="form-control">


                                @if($errors->action->has('action'))
                                    <div class="validator-error"><small>{{ $errors->action->first('action') }}</small></div>
                                @endif

                            </div>

                            <div class="form-group">
                                <label for="description">Descrição da ação</label>
                                <textarea type="text" name="description" class="form-control">{{ old('description', $action->description) }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="order">Ordem</label>
                                <input style="width: 50px;" type="text" name="order" value="{{ old('order', $action->order) }}" class="form-control">
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="active" {{ old('active', $action->active) ? 'checked' : '' }} value="1"> Ativo
                                </label>
                            </div>

                            <div class="form-group text-right">
                                <button class="btn btn-success">Salvar</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
