

$(document).ready(function () {


    // Obtener todos los botones de submenú
    document.querySelectorAll(".toggleSubmenu").forEach(button => {
        button.addEventListener("click", function (event) {
            event.preventDefault();
            let submenu = this.nextElementSibling;
            submenu.style.display = (submenu.style.display === "block") ? "none" : "block";
        });
    });

    // Obtener todos los botones de submenú en el menumobile
    document.querySelectorAll(".toggleSubmenuMobile").forEach(button => {
        button.addEventListener("click", function (event) {
            event.preventDefault();
            let submenu = this.nextElementSibling;
            submenu.style.display = (submenu.style.display === "block") ? "none" : "block";
        });
    });

    

    $("body").tooltip({
        selector: '[data-toggle=tooltip]'
    })

});


$(document).on('livewire:init', () => {

    Livewire.on('alerta', (event) => {

        let tipo = event.type;
        let msg = event.msg;

        switch (tipo) {
            case 'success':
                toastr.success(msg)
                break
            case 'error':
                toastr.error(msg)
                break
            case 'warning':
                toastr.warning(msg)
                break
        }
    })

    //logout
    $(document).on('click', "#logout", function (e) {
        e.preventDefault()
        if (confirm('¡Estas seguro que deseas salir del sistema?')) {
            $('#frmLogout').submit()
        }
    })

    //ver foto
    $(document).on('click', '.verFoto', function (e) {
        e.preventDefault()
        $('#modalVerFoto').modal('show')
    })

    //cerrar modal
    $(document).on('cerrarModal', function () {
        setTimeout(() => {
            $('.modal').modal('hide')
        }, 300);

    })

    //Enviar telegram alertas
    $(document).on('enviar-notificacion-telegram', function (event) {
        console.log(event.detail)
        fetch(encodeURI(`https://api.telegram.org/bot6050250438:AAFMUxeC57F7C9TxV5MBBLZDcKB7aUGXkgc/sendMessage?chat_id=${event.detail.destino}&text=${event.detail.msj}`))
    })

})