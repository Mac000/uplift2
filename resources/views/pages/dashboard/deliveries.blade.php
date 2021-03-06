@extends('components.master')
@include('components.dashboard.bulma_nav')

<div class="row cs-row-mr-0">
    <h3 class="card-header w-100 mb-2">All Deliveries</h3>
    <div class="table-responsive-lg ml-1">
        <table id="deliveriesTable" class="table table-hover">
            <thead class="thead-light">
            <tr>
                <th>Receiver</th>
                <th>#Phone</th>
                <th>Address</th>
                <th>GPS</th>
                <th>items/Goods</th>
                <th>cost</th>
                <th>Tehsil</th>
                <th>Delivered at</th>
                <th>Delivered By</th>
                <th>Evidence</th>
                <th>Help?</th>
            </tr>
            </thead>
        @foreach($deliveries as $collection)
            <!--    Its a collection returned by backend, so you have to loop to the internal array which contains
                attributes/values
            -->
                @forelse($collection as $delivery)
                    <tr>
                        <td>
                            <a class="text-capitalize cs-receiver-text"
                               href="{{ route('receiverData', ['receiver' => $delivery->receiver->id]) }}">{{ $delivery->receiver->name }}</a>
                        </td>
                        <td>{{ $delivery->receiver->phone_no }}</td>
                        <td>{{ $delivery->receiver->address }}</td>
                        <td>{{ $delivery->receiver->gps }}</td>
                        <td>{{ $delivery->goods }}</td>
                        <td>{{ $delivery->cost }}</td>
                        <td>{{ $delivery->receiver->tehsil }}</td>
                        <td>{{ $delivery->created_at->isoFormat('MMMM Do YYYY, h:mm:ss a')}}</td>
                        <td class="text-capitalize cs-receiver-text">{{ $delivery->user->name }}</td>
                        <td><a class="btn btn-primary" href="{{ $delivery->image }}">View</a></td>
                        <td><a class="btn btn-danger"
                               href="{{ route('help', ['receiver' => $delivery->receiver->id,'phone_no' => $delivery->receiver->phone_no]) }}">Check</a>
                        </td>
                    </tr>
                @empty
                    @component('components.bulma_warn')
                        @slot('message')
                            No deliveries exist far yet.
                        @endslot
                    @endcomponent
                @endforelse
            @endforeach
        </table>
    </div>
</div>

<div class="row justify-content-center mt-2">
    {{ $collection->links() }}
</div>

<script>

</script>

