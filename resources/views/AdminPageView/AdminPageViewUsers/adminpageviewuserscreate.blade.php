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
            <legend class="col-form-label col-sm-2 pt-0"><b>Privilage</b></legend>
            <div class="col-sm-10">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="is_admin"
                        id="is_admin" value=2 required>
                    <label class="form-check-label" for="admin">
                        Superadmin
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="is_admin"
                        id="is_admin" value=1 required>
                    <label class="form-check-label" for="admin">
                        Helper
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="is_admin"
                        id="is_admin" value=0 required>
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
