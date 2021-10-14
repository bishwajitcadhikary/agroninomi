(function ($) {
    $.fn.initValidate = function () {
        $(this).validate({
            errorClass: 'is-invalid text-danger',
            validClass: ''
        })
    }

    $.fn.initFormSubmit = function (callBackFunction = drawDataTable) {
        $(this).initValidate();

        $(this).ajaxForm({
            success: function (response) {
                console.log(response)
                Toast.fire({
                    icon: 'success',
                    title: response
                })
                $('#modal').modal('hide');
                callBackFunction();
            },
            error: function (response) {
                console.log(response)
                let errors = response.responseJSON;
                Toast.fire({
                    icon: 'error',
                    title: errors.message
                })
                showInputErrors(errors)
            }
        });
    }

}(jQuery));

function showInputErrors(errors) {
    $.each(errors['errors'], function (index, value) {
        $('#' + index + '-error').remove();
        $('#' + index).addClass('is-invalid')
            .after('<label id="' + index + '-error" class="is-invalid" for="' + index + '">' + value + '</label>')
    });
}


const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

function modal(header, url) {
    $.ajax({
        url: url,
        success: function (res) {
            $('#modal .modal-title').html(header);
            $('#modal .modal-body').html(res);
            $('#modal').modal('show');
        },
        error: function (res) {
            Toast.fire({
                icon: 'error',
                title: res.responseJSON.message
            })
        }
    })
}

let callBack;

function deleteModal(action, callBackFunction = drawDataTable) {
    $('#delete-modal').modal('show');
    $('#delete-form').attr('action', action)
    callBack = callBackFunction
}

let drawDataTable = function () {
    $('.dataTable').DataTable().draw();
}

$('#delete-form').ajaxForm({
    success: function (res) {
        Toast.fire({
            icon: 'success',
            title: res
        });
        $('#delete-modal').modal('hide');
        callBack()
    },
    error: function (res) {
        Toast.fire({
            icon: 'error',
            title: res.responseJSON.message
        })
    }
})
