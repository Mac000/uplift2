@extends('components.master')

@include('components.dashboard.bulma_nav')

<div class="row">
    <form method="post" class="col" action="/dashboard/post-item">
        @csrf
{{--        <textarea class="m-3 w-75" type="text" name="items"> </textarea>--}}
        <input class="m-3 w-75" type="number" name="members" placeholder="Number of members:">
        <br> <br>
        <input class="m-3 w-75" type="number" name="days" placeholder="Supplies for days: ">
        <br> <br>
        <textarea class="m-3 w-75" type="text" name="itemsjson"> </textarea>
        <button type="submit">Submit</button>
    </form>
</div>