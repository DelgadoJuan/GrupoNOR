var funcion;

function verificar_sesion() {
    let funcion = 'verificar_sesion';
    $.post('../Controllers/UsuarioController.php', {funcion}, (response) => {
        console.log(response);
        if(response != ''){
            let sesion = JSON.parse(response);
            $('#nav_login').hide();
            $('#nav_register').hide();
            $('#usuario_nav').text(sesion.user + ' #'+ sesion.id);
            $('#avatar_nav').attr('src', '../Util/Img/Users/' + sesion.avatar);
            $('#avatar_menu').attr('src', '../Util/Img/Users/' + sesion.avatar);
            $('#usuario_menu').text(sesion.user);
        }
        else{
            $('#nav_usuario').hide();
            location.href = 'login.php';
        }
    });
}

export {verificar_sesion};