document.addEventListener('DOMContentLoaded', function() {

    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault(); 
            
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#055038', // Verde
                cancelButtonColor: '#d33', // Rojo
                confirmButtonText: 'Sí, ¡Eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    const submenuToggles = document.querySelectorAll('.has-submenu');

    submenuToggles.forEach(function(toggle) {

        toggle.addEventListener('click', function(event) {
            
            event.preventDefault();

            const submenu = this.nextElementSibling;

            if (submenu && submenu.classList.contains('submenu')) {

                this.classList.toggle('active');

                submenu.classList.toggle('show');
            } else {
                console.error('¡ERROR! No se encontró el div.submenu después del botón:', this);
            }
        });
    });
});