document.addEventListener('DOMContentLoaded', function() {

    const deleteForms = document.querySelectorAll('.delete-form');
    deleteForms.forEach(form => {

        form.addEventListener('submit', function (event) {

            event.preventDefault(); 

            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esta acción!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#055038', // Verde 
                cancelButtonColor: '#d33', // Rojo
                confirmButtonText: 'Sí, ¡eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit(); 
                }
            });
        });
    });
});