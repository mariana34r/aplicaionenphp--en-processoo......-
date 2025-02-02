function mostrarFormulario(tipoFormulario) {

    document.getElementById("formularioInicio").classList.remove("activo");
    document.getElementById("formularioRegistro").classList.remove("activo");


    document.querySelector(".titulo1").style.display = "none";
    document.querySelector(".titulo2").style.display = "none";

    if (tipoFormulario === 'inicio') {
        document.getElementById("formularioInicio").classList.add("activo");
    } else if (tipoFormulario === 'registro') {
        document.getElementById("formularioRegistro").classList.add("activo");
    }
}

document.getElementById("formInicio").addEventListener("submit", function(evento) {
    evento.preventDefault();  

    var nombre = document.getElementsByName("nombre")[0].value;
    var correo = document.getElementsByName("correo")[0].value;


    var datosFormulario = new FormData();
    datosFormulario.append("nombre", nombre);
    datosFormulario.append("correo", correo);

    fetch("", {
        method: "POST",
        body: datosFormulario
    })
    .then(respuesta => respuesta.text())
    .then(datos => {
        
        document.getElementById("mensaje").innerText = datos;
    })
    .catch(error => {
        document.getElementById("mensaje").innerText = "Error al procesar la solicitud.";
    });
});


document.getElementById("formRegistro").addEventListener("submit", function(evento) {
    evento.preventDefault(); 

    var nombre = document.getElementsByName("nombre")[0].value;
    var correo = document.getElementsByName("correo")[0].value;
    var password = document.getElementsByName("password")[0].value;


    var datosFormulario = new FormData();
    datosFormulario.append("nombre", nombre);
    datosFormulario.append("correo", correo);
    datosFormulario.append("password", password);

    fetch("", {
        method: "POST",
        body: datosFormulario
    })
    .then(respuesta => respuesta.text())
    .then(datos => {
        
        document.getElementById("mensajeRegistro").innerText = datos;
    })
    .catch(error => {
        document.getElementById("mensajeRegistro").innerText = "Error al procesar la solicitud.";
    });
});