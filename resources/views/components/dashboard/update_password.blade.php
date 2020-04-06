<div id="accordion">
    <div class="card">
        <div class="card-header">
            <a class="card-link" data-toggle="collapse" href="#password">
                Update My Password
            </a>
        </div>

        <div id="password" class="collapse show" data-parent="#accordion">
            <div class="card-body">
                <form method="post" action="/dashboard/settings/update_password">
                    @csrf
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required
                               placeholder="New Passwword"
                        >
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required
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