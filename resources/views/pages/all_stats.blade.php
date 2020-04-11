@extends('components.master')
@include('components.nav')

<div class="row cs-row-mr-0 cs-row-ml-0">
    <h3 class="card-header w-100 mb-2">All Stats</h3>
    <div class="table-responsive-lg ml-1 cs-min-h-50">
        <table id="deliveriesTable" class="table table-hover">
            <thead class="thead-light">
            <tr>
                <th>Volunteer</th>
                <th>Tehsil</th>
                <th>People Reached</th>
                <th>Last 15 days</th>
                <th>Cost</th>
                <th>Last 15 days</th>
            </tr>
            </thead>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->tehsil }}</td>
                        <!--  Inner loop condition = $i < count of innermost array which is 4*count($users)  -->
                        @for( $i = 0; $i < count($users_stats[$loop->index]); $i++)
                            <!--  Display the entries from the innermost array. 4 per array.  -->
                            <td> {{$users_stats[$loop->index][$i]}}</td>
                        @endfor
                    </tr>
                    @empty
                    @component('components.bulma_warn')
                        @slot('message')
                            Stats are not available yet.
                        @endslot
                    @endcomponent
                @endforelse
        </table>
    </div>
</div>

<div class="row justify-content-center mt-2">
    {{ $users->links() }}
</div>

@include('components.footer')