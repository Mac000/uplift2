@extends('components.master')

@include('components.dashboard.bulma_nav')

<div class="row cs-row-mr-0 cs-row-ml-0">
    <h4 class="card-header w-100">Needed items</h4>
</div>

<div class="row">
    <div class="col-md">

        <div id="accordion" class="mt-2">
            <div class="card">
                <div class="card-header">
                    <a class="card-link" data-toggle="collapse" href="#color-codes">
                        <h5 class="text-warning text-center">Color codes</h5>
                    </a>
                </div>
                <div id="color-codes" class="collapse show" data-parent="#accordion">
                    <div class="card-body">
                        <span class="has-background-light cs-color-code">Needed quantity Between <strong>0.001 AND 5</strong></span>
                        <span class="has-background-info cs-color-code">Needed quantity Between <strong> 6 AND 15</strong></span>
                        <span class="has-background-warning cs-color-code">Needed quantity Between <strong>16 AND 25</strong></span>
                        <span class="has-background-danger cs-color-code">Needed quantity <strong>26+</strong></span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="row mt-3">
    <div class="col-md">
        @if(count($needs) === 0 and $help === 1)
            @component('components.bulma_warn')
                @slot('message')
                    This person has run out of supplies. Please try to arrange a new delivery. Last Recent Delivery
                    is
                    being shown for your reference!
                @endslot
            @endcomponent
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
                    </tr>
                    </thead>

                    <tr>
                        <td>
                            <a class="text-capitalize cs-receiver-text"
                               href="#">{{ $latest_delivery->receiver->name }}</a>
                        </td>
                        <td>{{$latest_delivery->receiver->phone_no }}</td>
                        <td>{{ $latest_delivery->receiver->address }}</td>
                        <td>{{ $latest_delivery->receiver->gps }}</td>
                        <td>{{ $latest_delivery->goods }}</td>
                        <td>{{ $latest_delivery->cost }}</td>
                        <td>{{ $latest_delivery->receiver->tehsil }}</td>
                        <td>{{ $latest_delivery->created_at->isoFormat('MMMM Do YYYY, h:mm:ss a')}}</td>
                        <td class="text-capitalize cs-receiver-text">{{ $latest_delivery->user->name }}</td>
                        <td><a class="btn btn-primary" href="{{ env('APP_URL', 'http://127.0.0.1:8000/') . $latest_delivery->image }}">View</a></td>
                    </tr>
                </table>
            </div>
        @endif
        <div class="cs-w-32 d-inline-block cs-mq-550">
            @if(count($needs) !== 0)
                @forelse($needs as $key => $item)
                    <div class="field is-grouped is-grouped-multiline">
                        <div class="control w-100">
                            <div class="tags has-addons w-100">
                                <span class="tag is-dark d-inline-block cs-w-70 p-2 cs-tag-font">{{ $key }}</span>

                                @if( preg_replace('/[^0-9]/', '', $item) >= 0 and $item <= 5)
                                    <span class="tag is-light cs-w-30 cs-tag-font">{{$item}}</span>

                                @elseif( preg_replace('/[^0-9]/', '', $item) >= 6 and $item <= 15)
                                    <span class="tag is-info cs-w-30 cs-tag-font">{{$item}}</span>

                                @elseif(preg_replace('/[^0-9]/', '', $item) >= 16 and $item <= 25)
                                    <span class="tag is-warning cs-w-30 cs-tag-font">{{$item}}</span>

                                @else(preg_replace('/[^0-9]/', '', $item) >= 26)
                                    <span class="tag is-danger cs-w-30 cs-tag-font">{{$item}}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                @empty
                    @component('components.bulma_warn')
                        @slot('message')
                            Thanks for checking in &#128522;
                            Needs are updated thrice a day at 6AM, 2PM, 8PM. please check back later.
                        @endslot
                    @endcomponent
                @endforelse
            @endif

            @if($invalid === 1)
                @component('components.bulma_alert_secondary')
                    @slot('message')
                        Your provided goods list did not follow the recommended format. Hence, we weren't able to
                        process it
                    @endslot
                @endcomponent
            @endif
        </div>
    </div>
</div>
