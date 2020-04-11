@component('errors::minimal')
{{--{{dd($exception)}}--}}
@section('title', __('Server Error'))
@slot('code')
    {{$exception->getStatusCode()}}
@endslot

@slot('message')
    {{$exception->getMessage()}}
@endslot
@endcomponent
