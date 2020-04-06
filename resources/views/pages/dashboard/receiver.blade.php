@extends('components.master')

@include('components.dashboard.bulma_nav')

<div class="row">
    <h2 class="card-header w-100 mb-2">History of {{$data[0]->receiver}}</h2>
    <div class="table-responsive-lg">
        <table class="table table-hover">
            <thead class="thead-light">
            <tr>
                <th>Receiver</th>
                <th>#Phone</th>
                <th>Address</th>
                <th>GPS</th>
                <th>items/Goods</th>
                <th>cost</th>
                <th>Delivered at</th>
                <th>Delivered By</th>
                <th>Evidence</th>
            </tr>
            </thead>
            @foreach($data as $record)
                <tr>
                    <td>{{ $record->receiver }}</td>
                    <td>{{ $record->phone_no }}</td>
                    <td>{{ $record->address }}</td>
                    <td>{{ $record->gps }}</td>
                    <td>{{ $record->goods }}</td>
                    <td>{{ $record->cost }}</td>
                    <td>{{ $record->created_at->isoFormat('MMMM Do YYYY, h:mm:ss a')}}</td>
                    <td>{{ $record->user->name }}</td>
                    <td><a href="http://127.0.0.1:8000/{{ $record->image }}">View</a></td>
                </tr>
            @endforeach
        </table>
    </div>
</div>

<div class="row justify-content-center mt-2">
    {{ $data->links() }}
</div>


