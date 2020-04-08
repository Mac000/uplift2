@extends('components.master')

@include('components.dashboard.bulma_nav')

<div class="row">
    <div class="col-md">
        <h4 class="card-header">Needed items</h4>
    </div>
</div>

<div class="row">
    <div class="col-md">
{{-- Use This format to display index/keys as well --}}
        @foreach($items as $key => $item)
            {{ $key }} -->> {{$item}}
        @endforeach
    </div>
</div>