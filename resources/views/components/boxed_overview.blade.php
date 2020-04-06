<div class="container-fluid">

    <div class="row">
        <div class="col-md">
            <div class="box">
                <h3 class="pt-3">Total People reached</h3>
                <span class="pt-3">{{$people}}</span>
            </div>
        </div>

        <div class="col-md">
            <div class="box">
                <h3 class="pt-3">Total cost</h3>
                <span class="pt-3">PKR. {{$cost}}</span>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md text-center text-info"><h2>Last 15 days</h2></div>
    </div>

    <div class="row">
        <div class="col-md">
            <div class="panel user text-center">
                <h3 class="pt-3">People reached</h3>
                <span class="pt-3">{{$people_15}}</span>
            </div>
        </div>
        <div class="col-md">
            <div class="panel cost text-center">
                <h3 class="pt-3">cost</h3>
                <span class="pt-3">PKR. {{$cost_15}}</span>
            </div>
        </div>
    </div>
</div>