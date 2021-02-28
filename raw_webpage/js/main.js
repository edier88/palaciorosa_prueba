
window.onload = mostrarTabla()

var myModalCrearUsuario = new bootstrap.Modal(document.getElementById('modalCrearUsuario'), {keyboard: true})
var myModalEditarUsuario = new bootstrap.Modal(document.getElementById('modalEditarUsuario'), {keyboard: true})


botonModalCrearUsuario.addEventListener("click", () => {
//botonModalCrearUsuario.onclick = () => {

    /* La funcion Axios funciona con 2 promesas internamente
    La primera promesa devuelve la operacion de alcanzar la URL 
    La segunda promesa resuelve la respuesta de todos los parámetros enviados
    Por eso se necesitan dos ".then"
    */

    var datos = new FormData();
    datos.append("username", username_create.value)
    datos.append("email", email_create.value)
    datos.append("passwd", passwd_create.value)
    datos.append("fechaNacimiento", fechaNacimiento_create.value)
    datos.append("sexo", sexo_create.value)
    datos.append("direccion", direccion_create.value)
    datos.append("accion", "create")
    datos.append("dataUsuario", true)

    axios({
        url: 'controller/userController.php',
        method: 'post',
        responseType: 'json',
        data: datos
    })
    .then((res) => {
        if(res.status==200) {
            return res.data
        }
        console.log(res)
    })
    .catch((error) => {
        console.log('Error de conexión ' + error)
    })
    .then((res) => {
        mostrarTabla()
        myModalCrearUsuario.hide()
    })
//}
})


function mostrarTabla(){

    // Aqui puede estar un loader corriendo
    axios({
        url: 'controller/userController.php',
        method: 'get',
        responseType: 'json',
        params:{
            "accion": "table",
            "dataUsuario": true
        }
    })
    .then((res) => {
        if(res.status==200) {
            return res.data // Le paso la respuesta al segundo ".then"
        }
        console.log(res);
        
    })
    .catch((error) => {
        //mensaje.innerText = 'Error de conexión ' + err;
        console.log('Error de conexión ' + error);
    })
    .then((res) => {
        // Aquí se puede apagar el loader
        mostrarTabla2(res)
    })    
}


function mostrarTabla2(data)  {
    
    let cadena = ""
    let edad = 0
    
    cadena += 
       `<table id=table1 style=width:100%>
            <tr>
                <th>ID</th>
                <th>User Name</th>
                <th>E-Mail</th>
                <th>Fedcha de Nacimiento</th>
                <th>Edad</th>
                <th>Sexo</th>
                <th>Direccion</th>
                <th>Fecha Creacion</th>
                <th>Fecha Modificacion</th>
                <th>Opciones</th>
            </tr>`
    data.forEach(element => {
        edad = calcularEdad(element.fecha_nacimiento)
        cadena+=
        `
        <tr>
            <td>${element.id}</td>
            <td>${element.username}</td>
            <td>${element.email}</td>
            <td>${element.fecha_nacimiento}</td>
            <td>${edad}</td>
            <td>${element.sexo}</td>
            <td>${element.direccion}</td>
            <td>${element.fecha_creacion}</td>
            <td>${element.fecha_modificacion}</td>
            <td>
                <div class="row justify-content-center">
                    <div class="col">
                        <button class="btn btn-success btn-sm" type="button" onclick="editUserModal(${element.id});"><i class="fa fa-edit"></i></button>
                    </div>
                    <div class="col">
                        <button class="btn btn-danger btn-sm" type="button" onclick="removeUser(${element.id});"><i class="fa fa-times"></i></button>
                    </div>
                </div>
            </td>
        </tr>
        `        
    })
    cadena += "</table>";
    tablaUsuarios.innerHTML = cadena
}

function editUserModal(id){

    axios({
        url: 'controller/userController.php',
        method: 'get',
        responseType: 'json',
        params:{
            "id_usuario": id,
            "accion": "show",
            "dataUsuario": true
        }
    })
    .then((res) => {
        if(res.status==200) {
            return res.data // Le paso la respuesta al segundo ".then"
        }
        console.log(res);
    })
    .catch((error) => {
        //mensaje.innerText = 'Error de conexión ' + err;
        console.log('Error de conexión ' + error);
    })
    .then((res) => {
        // Aquí se puede apagar el loader
        id_edit.value = res[0].id
        username_edit.value = res[0].username
        email_edit.value = res[0].email
        passwd_edit.value = "xxxxxxx"
        fechaNacimiento_edit.value = res[0].fecha_nacimiento
        sexo_edit.value = res[0].sexo
        direccion_edit.value = res[0].direccion
        myModalEditarUsuario.show()
        mostrarTabla()
    })
}

botonModalEditarUsuario.addEventListener("click", () =>{

    var datos = new FormData()
    datos.append("id_usuario", id_edit.value)
    datos.append("username", username_edit.value)
    datos.append("email", email_edit.value)
    datos.append("passwd", passwd_edit.value)
    datos.append("fechaNacimiento", fechaNacimiento_edit.value)
    datos.append("sexo", sexo_edit.value)
    datos.append("direccion", direccion_edit.value)
    datos.append("accion", "edit")
    datos.append("dataUsuario", true)

    axios({
        url: 'controller/userController.php',
        method: 'post',
        responseType: 'json',
        data: datos
    })
    .then((res) => {
        if(res.status==200) {
            return res.data
        }
        console.log(res)
    })
    .catch((error) => {
        console.log('Error de conexión ' + error)
    })
    .then((res) => {        
        myModalEditarUsuario.hide()
        mostrarTabla()
    })
})

function removeUser(id){
    if (confirm('¿Estas seguro de eliminar este usuario de la base de datos?')){

        var datos = new FormData();
        datos.append("id_usuario", id)
        datos.append("accion", "remove")
        datos.append("dataUsuario", true)

        axios({
            url: 'controller/userController.php',
            method: 'post',
            responseType: 'json',
            data: datos
        })
        .then((res) => {
            if(res.status==200) {
                return res.data
            }
            console.log(res)
        })
        .catch((error) => {
            console.log('Error de conexión ' + error)
        })
        .then((res) => {
            mostrarTabla()
        })
    }
}

function calcularEdad(fecha){
    var today = new Date();
    //var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate()
    var fechaArr = fecha.split("-");
    var year = 0

    year = today.getFullYear() - fechaArr[0]

    if ( (today.getMonth()+1) < fechaArr[1]){
        year = year-1
    } else if ( (today.getMonth()+1) == fechaArr[1] && (today.getDate()) < fechaArr[2] ) {
        year = year-1
    }
    return year
}