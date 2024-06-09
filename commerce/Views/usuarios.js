import { verificar_sesion } from "./sesion.js";

const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
    confirmButton: "btn btn-success m-3",
    cancelButton: "btn btn-danger"
    },
    buttonsStyling: false
});

$(document).ready(function() {
    verificar_sesion();
    $('#employeesTable').hide();

    $('#showClients').on('click', function() {
        toggleTables('#clientsTable', '#employeesTable');
    });

    $('#showEmployees').on('click', function() {
        toggleTables('#employeesTable', '#clientsTable');
    });
    obtener_usuarios();
});

function toggleTables(showTable, hideTable) {
    $(hideTable).hide();
    if ($.fn.DataTable.isDataTable(hideTable)) {
        $(hideTable).DataTable().destroy();
    }
    $(showTable).show();
    $(showTable).DataTable();
}

function obtener_usuarios() {
    $.ajax({
        url: '../Controllers/UsuarioController.php',
        method: 'POST',
        data: {
            funcion: 'obtener_usuarios'
        },
        success: function(response) {
            var usuarios = JSON.parse(response);
            var tablaClientes = '';
            var tablaEmpleados = '';
            usuarios.forEach(usuario => {
                var estadoOrden = usuario.estado === 'A' ? 'A' : 'I';
                var estadoIcono = usuario.estado === 'A' ? '<i class="fas fa-toggle-on"></i>' : '<i class="fas fa-toggle-off"></i>';
                var filaUsuario = `
                <tr data-id="${usuario.id}">
                    <td class="dni">${usuario.dni ? usuario.dni : ''}</td>
                    <td class="user">${usuario.user ? usuario.user : ''}</td>
                    <td class="nombres">${usuario.nombres ? usuario.nombres : ''}</td>
                    <td class="apellidos">${usuario.apellidos ? usuario.apellidos : ''}</td>
                    <td class="email">${usuario.email ? usuario.email : ''}</td>
                    <td class="telefono">${usuario.telefono ? usuario.telefono : ''}</td>
                    <td class="direccion">${usuario.direccion ? usuario.direccion : ''}</td>
                    <td class="referencia">${usuario.referencia ? usuario.referencia : ''}</td>
                `;
                if(usuario.id_tipo != 2) {
                    filaUsuario += `<td class="tipo_usuario">${usuario.tipo_usuario ? usuario.tipo_usuario : ''}</td>`;
                }
                filaUsuario += `
                    <td data-order="${estadoOrden}">${estadoIcono}</td>
                    <td>
                        <button class="btn btn-warning btn-sm editar_usuario" data-id="${usuario.id}" data-id-tipo="${usuario.id_tipo}" data-toggle="modal" data-target="#editEmployeeModal"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-danger btn-sm eliminar_usuario" data-id="${usuario.id}" data><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                `;
                if(usuario.id_tipo == 2) {
                    tablaClientes += filaUsuario;
                } else {
                    tablaEmpleados += filaUsuario;
                }
            });
            actualizarTablas(tablaClientes, tablaEmpleados);
        }
    });
}

function actualizarTablas(tablaClientes, tablaEmpleados) {
    $('#clientsTable').DataTable().destroy();
    $('#employeesTable').DataTable().destroy();
    $('#clientsTable tbody').html(tablaClientes);
    $('#employeesTable tbody').html(tablaEmpleados);
    $('#clientsTable').DataTable();
    $('#employeesTable').DataTable();
    agregarEventos();
}

function agregarEventos() {
    $('.fa-toggle-on, .fa-toggle-off').click(function() {
        var filaUsuario = $(this).closest('tr');
        var id_usuario = filaUsuario.data('id');
        var nuevoEstado = $(this).hasClass('fa-toggle-on') ? 'I' : 'A';
        cambiarEstadoUsuario(id_usuario, nuevoEstado);
    });

    $('.fa-trash').click(function() {
        var filaUsuario = $(this).closest('tr');
        var id_usuario = filaUsuario.data('id');
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¿Estás seguro de que quieres eliminar este usuario?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar!'
        }).then((result) => {
            if (result.isConfirmed) {
                eliminarUsuario(id_usuario);
            }
        });
    });

    document.querySelectorAll('.editar_usuario').forEach(boton => {
        boton.addEventListener('click', function() {
            let filaUsuario = this.closest('tr');
            var id_tipo = this.dataset.idTipo;

            if (id_tipo == 2) {
                document.querySelector('#editEmployeeForm #selectDiv').style.display = 'none';
                document.querySelector('#editEmployeeForm #tipoEmpleado').value = "";
            } else {
                document.querySelector('#editEmployeeForm #selectDiv').style.display = 'block';
                var select = document.querySelector('#editEmployeeForm #tipoEmpleado');
                if (select) {
                    select.value = id_tipo;
                }
            }

            document.querySelector('#editEmployeeForm #id_usuario').value = filaUsuario.dataset.id;
            document.querySelector('#editEmployeeForm #dni').value = filaUsuario.querySelector('.dni').textContent;
            document.querySelector('#editEmployeeForm #user').value = filaUsuario.querySelector('.user').textContent;
            document.querySelector('#editEmployeeForm #email').value = filaUsuario.querySelector('.email').textContent;
            document.querySelector('#editEmployeeForm #nombre').value = filaUsuario.querySelector('.nombres').textContent;
            document.querySelector('#editEmployeeForm #apellido').value = filaUsuario.querySelector('.apellidos').textContent;
            document.querySelector('#editEmployeeForm #telefono').value = filaUsuario.querySelector('.telefono').textContent;
            document.querySelector('#editEmployeeForm #direccion').value = filaUsuario.querySelector('.direccion').textContent;
            document.querySelector('#editEmployeeForm #referencia').value = filaUsuario.querySelector('.referencia').textContent;
        });
    });
}

function eliminarUsuario(id_usuario) {
    $.ajax({
        url: '../Controllers/UsuarioController.php',
        method: 'POST',
        data: {
            funcion: 'eliminar_usuario',
            id: id_usuario,
        },
        success: function(response) {
            swalWithBootstrapButtons.fire({
                title: "Exito!",
                text: "Usuario eliminado correctamente",
                icon: "success"
            });
            //alert('Usuario eliminado correctamente');
            obtener_usuarios(); // Actualizar la tabla
        }
    });
}

function cambiarEstadoUsuario(id_usuario, nuevoEstado) {
    $.ajax({
        url: '../Controllers/UsuarioController.php',
        method: 'POST',
        data: {
            funcion: 'modificar_estado_usuario',
            id: id_usuario,
            estado: nuevoEstado,
        },
        success: function(response) {
            swalWithBootstrapButtons.fire({
                title: "Exito!",
                text: "Estado modificado correctamente",
                icon: "success"
            });
            //alert('Estado modificado correctamente');
            obtener_usuarios(); // Actualizar la tabla
        }
    });
}

document.querySelector('#addEmployeeForm').addEventListener('submit', function(event) {
    event.preventDefault();
    let formData = new FormData(this);
    formData.append('funcion', 'registrar_empleado');
    $.ajax({
        url: '../Controllers/UsuarioController.php',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            $('#addEmployeeModal').modal('hide');
            swalWithBootstrapButtons.fire({
                title: "Exito!",
                text: "Empleado creado correctamente",
                icon: "success"
            });
            //alert('Empleado creado correctamente');
            obtener_usuarios();
        }
    });
});

document.querySelector('#editEmployeeForm').addEventListener('submit', function(event) {
    event.preventDefault();
    let formData = new FormData(this);
    formData.append('funcion', 'modificar_usuario');
    $.ajax({
        url: '../Controllers/UsuarioController.php',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            $('#editEmployeeModal').modal('hide');
            swalWithBootstrapButtons.fire({
                title: "Exito!",
                text: "Empleado actualizado correctamente",
                icon: "success"
            });
            //alert('Empleado actualizado correctamente');
            obtener_usuarios();
        }
    });
});