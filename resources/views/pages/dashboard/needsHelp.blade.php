@extends('components.master')

@include('components.dashboard.bulma_nav')

<div class="row cs-row-mr-0 cs-row-ml-0">
    <h4 class="card-header w-100">Needed items</h4>
</div>

<div class="row mt-3">
    <div class="col-md">
        <div class="cs-w-32 d-inline-block cs-mq-550">

            @forelse($needs as $key => $item)
                <div class="field is-grouped is-grouped-multiline">
                    <div class="control w-100">
                        <div class="tags has-addons w-100">
                            <span class="tag is-dark d-inline-block cs-w-70 p-2 cs-tag-font">{{ $key }}</span>

                            @if( preg_replace('/[^0-9]/', '', $item) <= 5)
                                <span class="tag is-light cs-w-30 cs-tag-font">{{$item}}</span>

                            @elseif( preg_replace('/[^0-9]/', '', $item) >= 10 and $item < 20)
                                <span class="tag is-info cs-w-30 cs-tag-font">{{$item}}</span>

                            @elseif(preg_replace('/[^0-9]/', '', $item) >= 20 and $item < 30)
                                <span class="tag is-warning cs-w-30 cs-tag-font">{{$item}}</span>

                            @else(preg_replace('/[^0-9]/', '', $item) >= 30)
                                <span class="tag is-danger cs-w-30 cs-tag-font">{{$item}}</span>
                            @endif
                        </div>
                    </div>
                </div>

            @empty
                @component('components.bulma_warn')
                    @slot('message')
                        Thanks for checking in &#128522;
                        Needs are updated twice a day. please check back at least 12hrs later.
                    @endslot
                @endcomponent
            @endforelse
        </div>
    </div>
</div>