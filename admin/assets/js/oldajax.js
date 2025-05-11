$(document).ready(function() {
    $('#addsoftwareForm').on('submit', function(e) {
        e.preventDefault();

        var submitBtn = $(this).find('button[type="submit"]');
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Saving...');

        var formData = new FormData(this);
        formData.append('csrf_token', '<?php echo $_SESSION['csrf_token']; ?>');

        $.ajax({
            url: '../../ajax/insertdb.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = 'software.php'; // ✅ Redirect after SweetAlert
                    });
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function(xhr) {
                let msg = "An unexpected error occurred.";
                try {
                    const res = JSON.parse(xhr.responseText);
                    msg = res.message || msg;
                } catch (e) {}
                Swal.fire('Request Failed', msg, 'error');
            },
            complete: function() {
                submitBtn.prop('disabled', false).html('<i class="fas fa-save me-2"></i>Save software');
            }
        });
    });
});