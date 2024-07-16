// ENVIAR DATOS de FORMULARIOS con AJAX y JAVASCRIPT
const formularios_ajax=document.querySelectorAll(".FormularioAjax");

//funcio para enviar fomrulario
function enviar_formulario(e){
    e.preventDefault();

    let enviar = confirm("¿Quieres enviar el formulario?");
    if(enviar == true){
        let data = new FormData(this);
        let method = this.getAttribute("method");
        let action = this.getAttribute("action");

        let encabezado = new Headers();

        let config={
            method: method,
            Headers: encabezado,
            mode: 'cors',
            caches: 'no-cache',
            body: data
        }

        //api fecth
        fetch(action,config)
        .then(respuesta => respuesta.text())
        .then(respuesta =>{
            let contenedor = document.querySelector(".form-rest");
            contenedor.innerHTML= respuesta;
        });
    }
}

//recorrer los fomularios
formularios_ajax.forEach(formularios => {
    formularios.addEventListener("submit",enviar_formulario);
});