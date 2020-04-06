@extends('components.master')
@include('components.nav')

<div class="row">
    <div class="col-md">
        <h3 class="card-header">About Uplift</h3>
    </div>
</div>

<div class="row">
    <div class="col-md">
        <p class="pl-3 p-1">Covid-19 has affected our lives greatly.
            Lot of people have lost their jobs or they cannot go to work resulting in "no income".
            Many families were already poor and had no savings.
            A big portion of population needs edible supplies in this time of crisis.
            People are providing volunteer services locally, which is great.
            However, their work can be made more efficient using ICT.
            Not only their workflow will become efficient but it will also provide us valuable insights and data to make informed decisions and have an accurate data of people who need help.
            This app is intended to be used by volunteers who are providing supplies to needy people.
        </p>
    </div>
</div>

<div class="row">
    <div class="col-md">
        <h4 class="pl-2 p-1">Why Use Uplift?</h4>
        <p class="pl-3 p-1">Government does not have proper data of poor people all across the country.
            Therefore, lot of people will not receive support but we cannot let them starve.
            However, people living in same town/village know the deserving people who need help.
            Therefore, when volunteers deliver supplies to them, by registering delivery on site, accurate database of deserving people will be created which can identify deserving right away.
            Volunteers can also track their efforts and determine who is still in need of HELP.
            Oh and lastly, COMPUTERS DO NOT LIE! You will have a precise record with evidence of what went to whom!
        </p>
    </div>
</div>

<div class="row">
    <div class="col-md">
        <h4 class="pl-2 p-1">Some Features</h4>
        <ol>
            <li class="ml-4">View all the deliveries.</li>
            <li class="ml-4">View all the deliveries to a specific person.</li>
            <li class="ml-4">Overview reports like
                <ol style="list-style-type: lower-alpha; padding-bottom: 0;">
                    <li style="margin-left:2em">Number of people who received deliveries</li>
                    <li style="margin-left:2em; padding-bottom: 0;">Total worth of deliveries</li>
                </ol>
            </li>
            <li class="ml-4">Overview report of each individual </li>
            <li class="ml-4">Helps in providing insights and valuable data to make informed decisions.</li>
            <li class="ml-4">Accurate data of deserving people in your area.</li>
        </ol>
    </div>
</div>

@include('components.footer')