@extends('components.master')
@include('components.dashboard.bulma_nav')

{{--@if(Session::has('success'))--}}
{{--    <div id="alert" class="notification is-success cs-alert">--}}
{{--        <button class="delete" onclick="hideAlert()"></button>--}}
{{--        {{ Session('success') }}--}}
{{--    </div>--}}
{{--@endif--}}

<h3 class="card-header mb-4">Settings</h3>

@include('components.dashboard.settings_form')
@include('components.success')


{{--<script>--}}
{{--    function hideAlert() {--}}
{{--        document.getElementById("alert").classList.add("d-none");--}}
{{--    }--}}
{{--</script>--}}