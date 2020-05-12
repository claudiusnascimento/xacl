@if(session()->has('xacl.alert'))

    @php
        $xacl_message = session()->pull('xacl.alert');
    @endphp
    <br>
    <div class="alert alert-{{ $xacl_message['type'] }}">
        {{ $xacl_message['message'] }}
    </div>
    <br>

@endif
