document.addEventListener('DOMContentLoaded', function(){
    Swal.fire({
        icon: 'success',
        title: 'Encuesta resuelta',
        text: 'Se respondio correctamente',
        confirmButtonText: 'Aceptar',
        allowEscapeKey: false,
        allowOutsideClick: false,
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = '../view/evaluate.php';
        }
    });
})