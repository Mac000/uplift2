<div class="row justify-content-center">
    <form method="post" action="/register-delivery" class="was-validated cs-sign-up ml-1 ml-md-4" enctype="multipart/form-data">
        @csrf
        <div class="row justify-content-center">
            <div class="col-sm">
                <h3 class="cs-auth-header text-center text-white m-2 p-2 temp-bg">Register Delivery</h3>
                <p class="text-center">Please register details of delivery</p>
                <hr class="m-2">
            </div>
        </div>

        <div class="form-group row justify-content-center">
            <div class="col-sm ml-1 mr-1 ml-md-4 mr-md-4">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <i class="cs-i-w-same input-group-text fa fa-drivers-license-o"></i>
                    </div>
                    <input type="text" class="form-control" id="name" placeholder="Receiver Name" name="receiver"
                           required>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
            </div>
        </div>

        <div class="form-group row justify-content-center">
            <div class="col-sm ml-1 mr-1 ml-md-4 mr-md-4">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <i class="cs-i-w-same input-group-text fa fa-drivers-license-o"></i>
                    </div>
                    <input type="text" class="form-control" id="tehsil" placeholder="Receiver Tehsil" name="tehsil"
                           required>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
            </div>
        </div>

        <div class="form-group row justify-content-center">
            <div class="col-sm ml-1 mr-1 ml-md-4 mr-md-4">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <i class="cs-i-w-same input-group-text fa fa-drivers-license-o"></i>
                    </div>
                    <input type="text" class="form-control" id="cnic" placeholder="Receiver CNIC, Do not use dashes!"
                           name="cnic" required>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
            </div>
        </div>

        <div class="form-group row justify-content-center">
            <div class="col-sm ml-1 mr-1 ml-md-4 mr-md-4">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <i class="cs-i-w-same input-group-text fa fa-envelope"></i>
                    </div>
                    <textarea class="form-control" id="address" placeholder="Full Address" name="address"
                              required></textarea>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
            </div>
        </div>

        <div class="form-group row justify-content-center">
            <div class="col-sm ml-1 mr-1 ml-md-4 mr-md-4">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <i class="cs-i-w-same input-group-text fa fa-mobile-phone"></i>
                    </div>
                    <input type="text" class="form-control" id="phone_no" placeholder="Phone Number, format: XXXXXXXXXXX" name="phone_no"
                           required maxlength="11">
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
            </div>
        </div>

        <div class="form-group row justify-content-center">
            <div class="col-sm ml-1 mr-1 ml-md-4 mr-md-4">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <i class="cs-i-w-same input-group-text fa fa-lock"></i>
                    </div>
                    <input type="text" class="form-control" id="gps" placeholder="GPS coordinates" name="gps" required>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
            </div>
        </div>

        <div class="form-group row justify-content-center">
            <div class="col-sm ml-1 mr-1 ml-md-4 mr-md-4">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <i class="cs-i-w-same input-group-text fa fa-envelope"></i>
                    </div>
                    <textarea class="form-control" id="goods"
                              placeholder="Please provide list of goods. One item per line" name="goods"
                              required></textarea>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
            </div>
        </div>

        <div class="form-group row justify-content-center">
            <div class="col-sm ml-1 mr-1 ml-md-4 mr-md-4">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <i class="cs-i-w-same input-group-text fa fa-lock"></i>
                    </div>
                    <input type="number" class="form-control" id="cost" placeholder="Total cost of goods" name="cost"
                           required max="15000">
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
            </div>
        </div>

        <div class="form-group row justify-content-center">
            <div class="col-sm ml-1 mr-1 ml-md-4 mr-md-4">
                <label class="mr-2" for="evidence">Evidence<span class="cs-required">*</span> (max size: 1MB, allowed:jpeg,png) </label>
                <input id="evidence" type="file" name="evidence" required>
            </div>
        </div>

        <div class="form-group row justify-content-center">
            <div class="col-sm ml-1 mr-1 ml-md-4 mr-md-4">
                <button type="submit" class="cs-brand-btn mb-2 w-100 temp-bg">Register</button>
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
        /*width: 45%;*/
        /*margin-right: auto;*/
        /*margin-left: auto;*/
        margin-bottom: 0.5rem;
    }
</style>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script>
    $(document).ready(function () {
        $('#cnic').tooltip({title: "Format: xxxxxxxxxxxxx", trigger: "click",});
        // delay: {show: 100, hide: 500}});
    });
</script>