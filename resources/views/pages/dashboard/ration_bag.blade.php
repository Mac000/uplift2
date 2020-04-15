@extends('components.master')
@include('components.dashboard.bulma_nav')

<div class="row justify-content-center">

    <form method="post" action="/dashboard/create-ration-bag" class="was-validated cs-sign-up ml-1 ml-md-4">
        @csrf
        <div class="row justify-content-center">
            <div class="col-sm">
                <h3 class="text-center text-white m-2 p-2 temp-bg">Create Ration Bag</h3>
                <p class="text-center">You can create your ration bags here</p>
                <hr class="m-2">
            </div>
        </div>

        <div class="form-group row justify-content-center">
            <div class="col-sm ml-1 mr-1 ml-md-4 mr-md-4">
                <input type="text" class="form-control" id="name" placeholder="Name your bag for your reference" name="name"
                       required maxlength="40">
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
        </div>

        <div class="form-group row justify-content-center">
            <div class="col-sm ml-1 mr-1 ml-md-4 mr-md-4">
                    <textarea class="form-control" id="ration"
                              placeholder="item1 quantity1,item2 quantity2" name="rations" required></textarea>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
        </div>

        <div class="form-group row justify-content-center">
            <div class="col-sm ml-1 mr-1 ml-md-4 mr-md-4">
                <button type="submit" class="cs-brand-btn mb-2 w-100 temp-bg">Create</button>
            </div>
        </div>
        @include('components.errors')
        @include('components.success')
    </form>

</div>

<style>
    .temp-bg {
        background-color: #32A932 !important;
    }
    .cs-sign-up {
        margin-top: 0.5rem;
        border: 1px solid #99AAB5;
        margin-bottom: 0.5rem;
    }
</style>