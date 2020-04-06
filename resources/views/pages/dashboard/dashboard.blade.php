@extends('components.master')

@include('components.dashboard.bulma_nav')

<div class="card-header row cs-row-mr-0 cs-flex-auto">
    <h3 class="text-center">Welcome {{\Illuminate\Support\Facades\Auth::user()->name}}</h3>
</div>
@include('components.dashboard.user_overview')
