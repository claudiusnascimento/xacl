@if(session()->has('xacl.alert'))
    <br>
    <div class="alert alert-{{ session()->get('xacl.alert')['type'] }}">
        {{ session()->get('xacl.alert')['message'] }}
    </div>
    <br>
@endif
