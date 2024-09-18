document.addEventListener('DOMContentLoaded', function(){
    Swal.fire({
        icon: 'success',
        title: 'Encuesta resuelta',
        text: 'Se respondio correctamente',
        confirmButtonText: 'ok',
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = '../evaluate.php';
        }
    });
})