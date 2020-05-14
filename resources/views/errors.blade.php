@php
    $ebg = isset($errorBagName) ? $errorBagName : 'default';
@endphp

@if($errors->{$ebg} && $errors->{$ebg}->any())
    <div id="html-block-message"></div>
    <ul class="alert alert-danger">
        @foreach($errors->{$ebg}->all() as $error)
            <li style="list-style-type: none;">{{ $error }}</li>
        @endforeach
    </ul>
@endif
