document.addEventListener('DOMContentLoaded', function(){
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'No se pudo enviar las respuestas de la encuesta. Porfavor intentalo de nuevo más tarde.',
        confirmButtonText: 'Aceptar',
    }).then((result) => {
        if (result.isConfirmed){
            window.location = '../evaluate.php';
        }
    });
})