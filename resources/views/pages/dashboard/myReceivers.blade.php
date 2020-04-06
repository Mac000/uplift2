@extends('components.master')
@include('components.dashboard.bulma_nav')

<div class="row cs-flex-auto ml-2">
    <h4 class="card-header w-100">My Receivers</h4>
    @foreach($receivers as $receiver)
        <div class="cs-w-48 ml-2 mt-2 p-1">
            <a class=""
               href="{{ route('receiverData', ['receiver' => $receiver->receiver]) }}">{{ $receiver->receiver }}</a>
        </div>
    @endforeach
</div>