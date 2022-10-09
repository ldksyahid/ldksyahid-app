<!-- Form Start -->
<div class="col-sm-12 col-xl-12">
    <form>
        <div class="mb-3">
            <label for="inputName1" class="form-label"><b>Name</b></label>
            <br>
            <label for="inputName1" class="form-label">{{ $data->name }}</label>
        </div>
        <div class="mb-3">
            <label for="inputEmail1" class="form-label"><b>Email Address</b></label>
            <br>
            <label for="inputEmail" class="form-label">{{ $data->email }}</label>
        </div>
        <div class="mb-3">
            <label for="inputPassword1" class="form-label"><b>Password</b></label>
            <br>
            <label for="inputPassword1" class="form-label">{{ ($data->password) }}</label>
        </div>
        <div class="mb-3">
            <label for="inputPosition1" class="form-label"><b>Position</b></label>
            <br>
            <label for="inputPosition" class="form-label">{{ $data->is_admin }}</label>
        </div>
    </form>

</div>
<!-- Form End -->
