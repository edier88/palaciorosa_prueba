
loginSubmit.onclick = () => {

    /* La funcion Axios funciona con 2 promesas internamente
    La primera promesa devuelve la operacion de alcanzar la URL 
    La segunda promesa resuelve la respuesta de todos los parámetros enviados
    Por eso se necesitan dos ".then"
    */

    var datos = new FormData();
    datos.append("nombre", user_login.value)
    datos.append("passwd", pass_login.value)
    datos.append("accion", "login")
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
        console.log(res)
    })
}