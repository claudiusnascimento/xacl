@extends(config('xacl.view.extends'))

@section(config('xacl.view.section'))

    <div class="row">

        <div class="col-xs-12">

            <div class="x_panel">
                <div class="x_content">

                    <div class="x_body">

                        @foreach($modules as $module)

                            <div class="xacl-module-box">
                                <div class="xacl-module-box__header">
                                    <small>{{ $module->getNameSpaceName() }}</small>
                                </div>
                                <div class="xacl-module-box__body">

                                    <h3 style="margin-top: 5px;">{{ $module->getDoc('class') }}</h3>

                                    <ul>
                                        @foreach($module->getMethods() as $method)
                                            <li>{{ $module->getDoc($method) }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="xacl-module-box__footer">
                                    <a href="#">Administrar</a>
                                </div>
                                <br><br>
                            </div>

                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
