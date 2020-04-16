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
            <h4 class="pl-2 p-1">General Guidelines</h4>
            <ol>
                <li class="ml-4">First of all, Register yourself on website.</li>
                <li class="ml-4">Login in you account</li>
                <li class="ml-4">You will be redirected to dashboard. This is the place where you will do everything
                </li>
                <li class="ml-4">From dashboard navigation menu, You can register a delivery, View all the deliveries,
                    Search for an individual delivery, view your receivers and then you can view their deliveries too.
                    Lastly, you can update your phone number and password.
                </li>
            </ol>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md">
            <h4 class="pl-2 p-1">Guide for Registering Delivery</h4>
            <ol>
                <li class="ml-4">Go to "Deliver to New Person" if you are delivering to a person for first time</li>
                <li class="ml-4">Go to "Deliver to existing Person" if you have already delivered to a person earlier</li>
                <li class="ml-4">Fill the form as per instructions in fields.</li>
                <li class="ml-4">Write Address in comma separated format. like: Mr.XYZ, block 4, House 10, Lahore</li>
                <li class="ml-4">Open up Google maps, access your position and copy paste the coordinates. Please provide coordinates of
                    your position at the address of Receiver.
                </li>
                <li class="ml-4">Provide comma separated list of goods. Please use "g" and "ml" for units. Example: Rice 5000g, flour 10000g</li>
                <li class="ml-4">The syntax for goods list is:</li>
                <li class="ml-4">item1 quantity1, item2 quantity2, item3 quantity 3</li>
                <li class="ml-4">pay attention to comma after every item and quantity, and use of space immediately after comma.</li>
                <li class="ml-4">If you want to create ration bag then SAME rules apply to that since the values in ration bag will be used as it is for "Goods"</li>
                <li class="ml-4">If some item has two names, e.g: "RedChilli" then use the "PascalCase" for naming. Remember Space and commas has a special meaning.</li>
                <li class="ml-4">The format and units for goods is important. Please don't violate it or the "Help needed" feature will not work properly</li>
                <li class="ml-4">Finally, Provide the cost of supplies, maximum amount is 15000</li>
                <li class="ml-4">Evidence image is required and it is expected that you take the picture while handing over goods to receiver</li>
                <li class="ml-4">If you have higher mega pixel cams then set the resolution to low mega pixel otherwise your image will be larger than 1MB</li>
            </ol>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md">
            <h4 class="pl-2 p-1">How "Help Needed Works"</h4>
            <ol>
                <li class="ml-4">There is a mechanism which checks receivers if they need help(with supplies) based on the goods provided to them</li>
                <li class="ml-4">This works by comparing a list of ESSENTIAL items against the list of provided items to receiver</li>
                <li class="ml-4">Anything which is not inside Essential items will not be counted toward "Help needed"</li>
                <li class="ml-4">This routine/mechanism is executed after every 12hrs</li>
                <li class="ml-4">This feature is basically meant to check if the provided supplies are enough for a given number of days</li>
                <li class="ml-4">After that number of days, the "help needed" is cleared</li>
                <li class="ml-4">As long as no new delivery is made to that particular receiver, this feature will not check the specific receiver</li>
                <li class="ml-4">A table of essentials for one person/day is given below. Items and quantities shown here are used in System</li>
            </ol>
        </div>
    </div>

    @include('components.essentials_table')
</div>

@include('components.footer')