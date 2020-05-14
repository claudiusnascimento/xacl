@extends(config('xacl.view.extends'))

@section(config('xacl.view.section'))

    <div class="row">

        <div class="col-xs-12">

            <div class="x_panel">
                <div class="x_content">

                    @include('xacl::messages')

                    <div class="x_body">

                        @foreach($actions as $action)

                            <div class="box-group clearfix">
                                <h3>{{ $action->action }}</h3>
                                <p>{{ empty(trim(strip_tags($action->description))) ? 'Sem descrição' : $action->description }}</p>
                                <div class="div">
                                    <h5>{{ $action->active ? 'ATIVADO' : 'DESATIVADO' }}</h5>
                                </div>

                                <form
                                    class="delete-group-form pull-left"
                                    action="{{ route('xacl.actions.delete', $action->id) }}"
                                    enctype="multipart/form-data"
                                    method="POST">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button type="submit" class="btn btn-danger md btn-delete-action">Deletar ação</button>
                                </form>

                                <a href="{{ route('xacl.actions.edit', $action->id) }}" class="btn btn-success md">Editar ação</a>
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

                        <h3>Cadastrar nova ação</h3>

                        <form
                            action="{{ route('xacl.actions.store') }}"
                            enctype="multipart/form-data"
                            method="POST">

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label for="action">Nome da ação</label>
                                <input type="text" name="action" value="{{ old('action') }}" class="form-control">


                                @if($errors->action->has('action'))
                                    <div class="validator-error"><small>{{ $errors->action->first('action') }}</small></div>
                                @endif

                            </div>

                            <div class="form-group">
                                <label for="description">Descrição da ação</label>
                                <textarea type="text" name="description" class="form-control">{{ old('description') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="order">Ordem</label>
                                <input style="width: 50px;" type="text" name="order" value="{{ old('order') }}" class="form-control">
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="active" {{ old('active') ? 'checked' : '' }} value="1"> Ativo
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
