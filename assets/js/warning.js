document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        icon: 'warning',
        title: 'La encuesta ya esta resuelta',
        text: 'No puedes volver a responderla.',
        confirmButtonText: 'ok'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = '../evaluate.php';
        }
    });
});