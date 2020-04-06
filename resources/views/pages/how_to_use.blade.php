@extends('components.master')
@include('components.nav')

<div class="container-fluid pl-0 pr-0">
    <div class="row">
        <div class="col-md">
            <h3 class="card-header">How to Use</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md">
            <ol>
                <li class="ml-4">First of all, Register yourself on website.</li>
                <li class="ml-4">Login in you account</li>
                <li class="ml-4">You will be redirected to dashboard. This is the place where you will do everything
                </li>
                <li class="ml-4">From dashboard navigation menu, You can register a delivery, View all the deliveries,
                    Search
                    for an individual delivery, view your receivers and then you can view their deliveries too. Lastly,
                    you can update your phone
                    number and password.
                </li>
                {{--            <li class="ml-4"></li>--}}
            </ol>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-md">
            <h4 class="pl-2 p-1">Guide for registering Delivery</h4>
            <ol>
                <li class="ml-4">Go to register delivery</li>
                <li class="ml-4">Fill the form as per instructions in fields.</li>
                <li class="ml-4">Write Address in comma separated format. like: Mr.XYZ, block 4, House 10, Lahore</li>
                <li class="ml-4">Open up Google maps, access your position and copy paste the coordinates. Please provide coordinates of
                    your position at the address of Receiver.
                </li>
                <li class="ml-4">Put one Item per line along. Provide quantity/number as well. Example: Rice 5kg</li>
                <li class="ml-4">Finally, Provide the cost of supplies, maximum amount is 15000</li>
            </ol>
        </div>
    </div>

</div>

@include('components.footer')