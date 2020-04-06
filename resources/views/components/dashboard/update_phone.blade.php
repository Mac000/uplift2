 <div id="accordion">
        <div class="card">
            <div class="card-header">
                <a class="card-link" data-toggle="collapse" href="#phone">
                    Update My Phone Number
                </a>
            </div>

            <div id="phone" class="collapse show" data-parent="#accordion">
                <div class="card-body">
                    <form method="post" action="/dashboard/settings/update_phone">
                        @csrf
                        <div class="form-group">
                            <label for="phone_no">Phone Number</label>
                            <input type="text" class="form-control" id="phone_no" name="phone_no" required maxlength="11"
                                   placeholder="03xxxxxxxxxxx"
                            >
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                        <div class="form-group">
                            <label for="verify_password">Verify Password</label>
                            <input type="password" class="form-control" id="verify_password" name="verify_password" required
                                   placeholder="Current password to verify your action"
                            >
                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>
                        <div class="cs-btn-wrapper">
                            <button type="submit" class="btn btn-outline-info">Update</button>
                        </div>
                        @include('components.errors')
                    </form>
                </div>
            </div>

        </div>
    </div>