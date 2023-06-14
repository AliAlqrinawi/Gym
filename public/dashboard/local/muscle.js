let host = document.location;

let MuscleUrl = new URL('/admin/muscle', host.origin);
let pathSegments = host.pathname.split('/');
let currentLang = pathSegments[1];
if(currentLang != 'ar' || currentLang != 'en'){
    currentLang = 'en';
}

var muscle = $('#get_muscle').DataTable({
    processing: true,
    ajax: MuscleUrl,
    columns: [
        {data: "DT_RowIndex", name: "DT_RowIndex"},
        // {data: "image", name: "image"},
        {data: "title", name: "title"},
        {data: "status", name: "status"},
        {data: "action", name: "action"},
    ]
});
//  view modal muscle
$(document).on('click', '#ShowModalMuscle', function (e) {
    e.preventDefault();
    $('#modalMuscleAdd').modal('show');
});

let AddUrl = new URL('admin/muscle', host.origin);
// category admin
$(document).on('click', '#addMuscle', function (e) {
    e.preventDefault();
    let formdata = new FormData($('#formMuscleAdd')[0]);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        url: AddUrl,
        data: formdata,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.status == 400) {
                // errors
                $('#list_error_message').html("");
                $('#list_error_message').addClass("alert alert-danger");
                $('#list_error_message').text(response.message);
            } else {
                $('#error_message').html("");
                $('#error_message').addClass("alert alert-success");
                $('#error_message').text(response.message);
                $('#modalMuscleAdd').modal('hide');
                $('#formMuscleAdd')[0].reset();
                muscle.ajax.reload(null, false);
            }
        }
    });
});

let EditUrl = new URL('admin/muscle', host.origin);
// view modification data
$(document).on('click', '#showModalEditMuscle', function (e) {
    e.preventDefault();
    var id = $(this).data('id');
    $('#modalMuscleUpdate').modal('show');
    $.ajax({
        type: 'GET',
        url: EditUrl+'/' + id+'/edit',
        data: "",
        success: function (response) {
            if (response.status == 404) {
                $('#error_message').html("");
                $('#error_message').addClass("alert alert-danger");
                $('#error_message').text(response.message);
            } else {
                $('#id').val(id);
                $('#title_en').val(response.data.title_en);
                $('#title_ar').val(response.data.title_ar);
                $("#status option[value='"+response.data.status+"']").prop("selected", true);
            }
        }
    });
});

let UpdateUrl = new URL('admin/muscle', host.origin);
$(document).on('click', '#updateMuscle', function (e) {
    e.preventDefault();
    let formdata = new FormData($('#formMuscleUpdate')[0]);
    var id = $('#id').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        url: UpdateUrl+'/'+id,
        data: formdata,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.status == 400) {
                // errors
                $('#list_error_message2').html("");
                $('#list_error_message2').addClass("alert alert-danger");
                $('#list_error_message2').text(response.message);
            } else {
                $('#error_message').html("");
                $('#error_message').addClass("alert alert-success");
                $('#error_message').text(response.message);
                $('#modalMuscleUpdate').modal('hide');
                $('#formMuscleUpdate')[0].reset();
                muscle.ajax.reload(null, false);
            }
        }
    });
});

let DeleteUrl = new URL('admin/muscle', host.origin);
$(document).on('click', '#showModalDeleteMuscle', function (e) {
    e.preventDefault();
    $('#nameDetele').val($(this).data('name'));
    var id = $(this).data('id');
    $('#modalMuscleDelete').modal('show');
    gg(id);
});
function gg(id) {
    $(document).off("click", "#deleteMuscle").on("click", "#deleteMuscle", function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'DELETE',
            url: DeleteUrl+'/'+id,
            data: '',
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status == 400) {
                    // errors
                    $('#list_error_message3').html("");
                    $('#list_error_message3').addClass("alert alert-danger");
                    $('#list_error_message3').text(response.message);
                } else {
                    $('#error_message').html("");
                    $('#error_message').addClass("alert alert-success");
                    $('#error_message').text(response.message);
                    $('#modalMuscleDelete').modal('hide');
                    muscle.ajax.reload(null, false);
                }
            }
        });
    });
}

let statusUrl = new URL('admin/status/muscle', host.origin);
$(document).on('click', '#status', function (e) {
    e.preventDefault();
    var id = $(this).data('id');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'PUT',
        url: statusUrl+'/'+id,
        data: "",
        success: function (response) {
             if (response.status == 400) {
                    // errors
                    $('#list_error_message3').html("");
                    $('#list_error_message3').addClass("alert alert-danger");
                    $('#list_error_message3').text(response.message);
                } else {
                    $('#error_message').html("");
                    $('#error_message').addClass("alert alert-success");
                    $('#error_message').text(response.message);
                    muscle.ajax.reload(null, false);
                }
        }
    });
});

//  close action
$(document).on('click', '#close', function (e) {
    e.preventDefault();
    $('#formExerciseAdd')[0].reset();
});
