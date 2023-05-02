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
            <label for="inputPassword1" class="form-label"><b>Subject</b></label>
            <br>
            <label for="inputPassword1" class="form-label">{{ ($data->subject) }}</label>
        </div>
        <div class="mb-3">
            <label for="inputPosition1" class="form-label"><b>Message</b></label>
            <br>
            <label for="inputPosition" class="form-label">{{ $data->message }}</label>
        </div>
    </form>

</div>
<!-- Form End -->
