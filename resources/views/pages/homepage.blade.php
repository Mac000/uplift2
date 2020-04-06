@extends('components.master')
{{--@include('components.header')--}}
@include('components.nav')

<body>
    <div class="gradient-hero row justify-content-center align-items-center" style="margin: 0">
        <div class="col-md">
            <h3 class="text-center text-white">In this time of crisis, let's do our best to Uplift people around us! <br>
            Uplift makes it easier and provides valuable insights to volunteers about the the needy people around them
            </h3>
        </div>
    </div>
    @include('components.overview')
</body>

@include('components.footer')