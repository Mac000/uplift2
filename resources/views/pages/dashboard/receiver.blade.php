@extends('components.master')

@include('components.dashboard.bulma_nav')

<div class="row">
{{--    {{dd($data)}}--}}
    <h2 class="card-header w-100 mb-2">History of {{$data[0]->receiver->name}}</h2>
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
                <th>Help</th>
            </tr>
            </thead>
            @foreach($data as $record)
                <tr>
                    <td class="text-capitalize cs-receiver-text">{{ $record->receiver->name }}</td>
                    <td>{{ $record->receiver->phone_no }}</td>
                    <td>{{ $record->receiver->address }}</td>
                    <td>{{ $record->receiver->gps }}</td>
                    <td>{{ $record->goods }}</td>
                    <td>{{ $record->cost }}</td>
                    <td>{{ $record->created_at->isoFormat('MMMM Do YYYY, h:mm:ss a')}}</td>
                    <td class="text-capitalize cs-receiver-text">{{ $record->user->name }}</td>
                    <td><a class="btn btn-primary"  href="{{config('app.app_url')}}/{{ $record->image }}">View</a></td>
                    <td><a class="btn btn-danger"
                           href="{{ route('help', ['receiver' => $record->receiver->id,'phone_no' => $record->receiver->phone_no]) }}">Check</a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>

<div class="row justify-content-center mt-2">
    {{ $data->links() }}
</div>


