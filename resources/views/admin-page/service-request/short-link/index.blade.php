@extends('admin-page.template.body')

@section('content')
<!-- Table Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-xl-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">Request Shortlink Database</h5>
                {{-- START Data Request Shortlink --}}
                <div id="readReqShortlink" class="mt-3"></div>
                {{-- END Data Request Shortlink --}}
            </div>
        </div>
    </div>
</div>
<!-- Table End -->
<!-- Modal -->
<div class="modal fade" id="modalCrudReqShortlink" tabindex="-1" aria-labelledby="modalLabelCrudReqShortlink" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content bg-light rounded h-100 p-4">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabelCrudReqShortlink">Modal title</h5>
                <button type="button" class="btn btn-close btn-primary" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="pageReqShortlink"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // ===== START CRUD USER =====
    // untuk load database
    $(document).ready(function(){
        read();
    });


    //untuk read database
    function read() {
        $.get("{{ url('/admin/reqservice/shortlink/read') }}", {}, function(data, status){
            $('#readReqShortlink').html(data);
        });
    }

    // Untuk modal halaman edit show
    function addFixCustomLink(id) {
        $.get(`{{ url('/admin/reqservice/shortlink/${id}/addcustomlink') }}`, {}, function(data, status) {
            $("#modalLabelCrudReqShortlink").html('Edit Request Shortlink')
            $("#pageReqShortlink").html(data);
            $("#modalCrudReqShortlink").modal('show');
        });
    }

    // untuk update database
    function updateFixCustomLink(id) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1500,
            width: '350px',
        })
        var name = $("#name").val();
        var email = $("#email").val();
        var whatsapp = $("#whatsapp").val();
        var defaultLink = $("#defaultLink").val();
        var customLink = $("#customLink").val();
        var note = $("#note").val();
        var fixCustomLink = $("#fixCustomLink").val();
        console.log(customLink );
        $.ajax({
            type: "get",
            url: `{{ url('/admin/reqservice/shortlink/${id}/addcustomlink/update') }}`,
            data: {
                name: name,
                email: email,
                whatsapp: whatsapp,
                defaultLink: defaultLink,
                customLink: customLink,
                note: note,
                fixCustomLink: fixCustomLink },
            success: function(data) {
                if($.isEmptyObject(data.error)){
                    $(".btn-close").click();
                    read();
                    Toast.fire({
                        icon: 'success',
                        title: 'Request Shortlink has been updated !'
                    });
                }else{
                    printErrorMsg(data.error);
                }

            }
        });
    }

    function printErrorMsg (msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display','block');
        $.each( msg, function( key, value ) {
            $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
        });
    }

    // untuk destroy database
    function destroyReqShortlink(id) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1500,
            width: '350px',
        })

        Swal.fire({
            title: 'Are you sure ?',
            text: "You won't be able to revert this !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "get",
                    url: `{{ url('/admin/reqservice/shortlink/${id}/destroy') }}`,
                    success: function(data) {
                        $(".btn-close").click();
                        read();
                        Toast.fire({
                            icon: 'success',
                            title: 'Request Shortlink has been deleted !'
                        });
                    }
                });
            }
        })
    }

    // untuk modal preview
    function previewReqShortlink(id) {
        $.get(`{{ url('/admin/reqservice/shortlink/${id}/preview') }}`, {}, function(data, status) {
            $("#modalLabelCrudReqShortlink").html('Preview Request Shortlink')
            $("#pageReqShortlink").html(data);
            $("#modalCrudReqShortlink").modal('show');
        });
    }
    // ===== END CRUD USER =====
</script>
@endsection
