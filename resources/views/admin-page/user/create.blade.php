<!-- Form Start -->
<div class="row">
    <div class="col-12 col-lg-12">
        <div class="alert alert-danger print-error-msg small pb-0 error-field fade-in shadow-sm">
            <span><i class="fa fa-exclamation-circle fa-1x me-2"></i>Error Message :</span>
            <br>
            <ul></ul>
        </div>
    </div>
    <div class="col-12 col-lg-12 mb-3">
        <label for="inputName1" class="form-label required"><b>Name</b></label>
        <input type="text" class="form-control" id="inputName1" required>
    </div>
    <div class="col-12 col-lg-6 mb-3">
        <label for="inputEmail1" class="form-label required"><b>Email</b></label>
        <input type="email" class="form-control" id="inputEmail1" aria-describedby="emailHelp">
    </div>
    <div class="col-12 col-lg-6 mb-3">
        <label for="inputPassword1" class="form-label required"><b>Password</b></label>
        <input type="password" class="form-control" id="inputPassword1">
    </div>
    <div class="col-12 col-lg-12">
        <fieldset class="row mb-3">
            <legend class="col-form-label col-sm-2 pt-0 required"><b>Role Name</b></legend>
            <div class="col-sm-10">
                <div class="form-check">
                    <input class="form-check-input roleName" type="radio" name="roleName"
                        id="roleNameSuperadmin" value='Superadmin'>
                    <label class="form-check-label" for="superadmin">
                        <i class="badge badge-pill bg-danger">Superadmin</i>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input roleName" type="radio" name="roleName"
                        id="roleNameHelperAdmin" value='HelperAdmin'>
                    <label class="form-check-label" for="helperadmin">
                        <i class="badge badge-pill bg-warning">HelperAdmin</i>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input roleName" type="radio" name="roleName"
                        id="roleNameHelperCelsyahid" value='HelperCelsyahid'>
                    <label class="form-check-label" for="helpercelsyahid">
                        <i class="badge badge-pill bg-success">HelperCelsyahid</i>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input roleName" type="radio" name="roleName"
                        id="roleNameHelperLetter" value='HelperLetter'>
                    <label class="form-check-label" for="helperletter">
                        <i class="badge badge-pill bg-secondary">HelperLetter</i>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input roleName" type="radio" name="roleName"
                        id="roleNameHelperEvent" value='HelperEventMart'>
                    <label class="form-check-label" for="helpereventmart">
                        <i class="badge badge-pill" style="background-color: #5352ed;">HelperEventMart</i>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input roleName" type="radio" name="roleName"
                        id="roleNameHelperSPAM" value='HelperSPAM'>
                    <label class="form-check-label" for="helperspam">
                        <i class="badge badge-pill bg-info">HelperSPAM</i>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input roleName" type="radio" name="roleName"
                        id="roleNameHelperMedia" value='HelperMedia'>
                    <label class="form-check-label" for="helpermedia">
                        <i class="badge badge-pill bg-dark">HelperMedia</i>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input roleName" type="radio" name="roleName"
                        id="user" value='User'>
                    <label class="form-check-label" for="user">
                        <i class="badge badge-pill bg-primary">User</i>
                    </label>
                </div>
            </div>
        </fieldset>
    </div>
    <div>
        <button type="submit" class="btn btn-primary" onClick="store()">Create</button>
    </div>
</div>
<!-- Form End -->
