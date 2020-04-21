@extends(config('xacl.view.extends'))

@section(config('xacl.view.section'))

    <div class="row">

        <div class="col-xs-12">

            <div class="x_panel">
                <div class="x_content">

                    <div class="x_body">

                        @foreach($groups as $group)

                            <div class="box-group">
                                <h3>{{ $group->name }}</h3>
                                <p>{{ empty(trim(strip_tags($group->description))) ? 'Sem descrição' : $group->description }}</p>
                                <div class="div">
                                    <h5>{{ $group->active ? 'ATIVADO' : 'DESATIVADO' }}</h5>
                                </div>
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

                        <h3>Cadastrar novo grupo</h3>

                        @if(session()->has('xacl.alert'))
                            <br>
                            <div class="alert alert-{{ session()->get('xacl.alert')['type'] }}">
                                {{ session()->get('xacl.alert')['message'] }}
                            </div>
                            <br>
                        @endif

                        <form
                            action="{{ route('xacl.groups.store') }}"
                            enctype="multipart/form-data"
                            method="POST">

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label for="name">Nome do grupo</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control">

                                @if($errors->group->any())
                                    <div class="validator-error"><small>{{ $errors->group->get('name')[0] }}</small></div>
                                @endif

                            </div>

                            <div class="form-group">
                                <label for="description">Descrição do grupo</label>
                                <textarea type="text" name="description" class="form-control">{{ old('description') }}</textarea>
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
