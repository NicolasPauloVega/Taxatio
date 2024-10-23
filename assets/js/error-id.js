document.addEventListener('DOMContentLoaded', function(){
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'No se encontro un instructor por evaluar',
        confirmButtonText: 'Aceptar',
        allowEscapeKey: false,
        allowOutsideClick: false,
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = '../view/evaluate.php';
        }
    });
})