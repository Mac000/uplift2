<div class="container-fluid">

    <div class="row cs-row-mr-0 cs-flex-auto">
        <div class="col-sm-12">
            <h4 class="text-center mt-3 mb-2 pb-1 cs-stats">Stats</h4>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md cs-panel user text-center m-3 m-md-4">
            <h3 class="pt-3">Total People reached</h3>
            <span class="pt-3">{{$people}}</span>
        </div>

        <div class="col-md cs-panel cost text-center m-3 m-md-4">
            <h3 class="pt-3">Total cost</h3>
            <span class="pt-3">PKR. {{$cost}}</span>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md cs-panel user text-center m-3 m-md-4">
            <h3 class="pt-3">People reached in last 15 days</h3>
            <span class="pt-3">{{$people_15}}</span>
        </div>
        <div class="col-md cs-panel cost text-center m-3 m-md-4">
            <h3 class="pt-3">Cost in last 15 days</h3>
            <span class="pt-3">PKR. {{$cost_15}}</span>
        </div>
    </div>

</div>