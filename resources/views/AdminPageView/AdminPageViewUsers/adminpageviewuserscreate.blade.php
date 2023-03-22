<!-- Form Start -->
<div class="col-sm-12 col-xl-12">
    <div>
        <div class="mb-3">
            <label for="inputName1" class="form-label"><b>Name</b></label>
            <input type="text" class="form-control" id="inputName1" placeholder="Enter the Name...">
        </div>
        <div class="mb-3">
            <label for="inputEmail1" class="form-label"><b>Email address</b></label>
            <input type="email" class="form-control" id="inputEmail1" aria-describedby="emailHelp" placeholder="Enter the Email...">
        </div>
        <div class="mb-3">
            <label for="inputPassword1" class="form-label"><b>Password</b></label>
            <input type="password" class="form-control" id="inputPassword1" placeholder="Enter the Password...">
        </div>
        <fieldset class="row mb-3">
            <legend class="col-form-label col-sm-2 pt-0"><b>Role</b></legend>
            <div class="col-sm-10">
                <div class="form-check">
                    <input class="form-check-input roleName" type="radio" name="roleName"
                        id="roleNameSuperadmin" value='Superadmin' required>
                    <label class="form-check-label" for="superadmin">
                        Superadmin
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input roleName" type="radio" name="roleName"
                        id="roleNameHelperAdmin" value='HelperAdmin' required>
                    <label class="form-check-label" for="helperadmin">
                        HelperAdmin
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input roleName" type="radio" name="roleName"
                        id="roleNameHelperCelsyahid" value='HelperCelsyahid' required>
                    <label class="form-check-label" for="helpercelsyahid">
                        HelperCelsyahid
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input roleName" type="radio" name="roleName"
                        id="roleNameHelperLetter" value='HelperLetter' required>
                    <label class="form-check-label" for="helperletter">
                        HelperLetter
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input roleName" type="radio" name="roleName"
                        id="roleNameHelperEvent" value='HelperEventMart' required>
                    <label class="form-check-label" for="helpereventmart">
                        HelperEventMart
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input roleName" type="radio" name="roleName"
                        id="roleNameHelperSPAM" value='HelperSPAM' required>
                    <label class="form-check-label" for="helperspam">
                        HelperSPAM
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input roleName" type="radio" name="roleName"
                        id="roleNameHelperMedia" value='HelperMedia' required>
                    <label class="form-check-label" for="helpermedia">
                        HelperMedia
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input roleName" type="radio" name="roleName"
                        id="user" value='User' required>
                    <label class="form-check-label" for="user">
                        User
                    </label>
                </div>
            </div>
        </fieldset>
        <button type="submit" class="btn btn-primary" onClick="store()">Create</button>
    </div>

</div>
<!-- Form End -->
