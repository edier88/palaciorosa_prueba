
window.onload = mostrarTabla()


$("#botonModalCrearUsuario").click(function(){
    
    $.ajax({
        url:'controller/usuarioController.php',
        data: {
            "usuario": usuario_create.value,
            "accion": "crear",
            "dataUsuario": true
        },
        beforeSend: function(objeto){
            //$("#respuestaCrearUsuario").html("<img src='../imagenes/loader.gif'>");
        },
        success:function(data){
            if (data == 1){
                $("#modalCrearUsuario").modal("hide")
                mostrarTabla()
            }
        }
    })
})



function mostrarTabla(){
    var today = new Date();
    var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate()
    $.ajax({
        url:'controller/usuarioController.php',
        data: {
            "accion": "tabla",
            "dataUsuario": true
        },
        beforeSend: function(objeto){
            //$("#respuestaCrearUsuario").html("<img src='../imagenes/loader.gif'>");
        },
        success:function(data){
            cadena = ""
            console.log(data)
            var parsed = JSON.parse(data)
            //console.log(parsed)
            cadena += 
            "<table id='table1' style='width:100%'>"+
                "<tr>"+
                    "<th>ID</th>"+
                    "<th>nombre</th>"+
                    "<th>E-Mail</th>"+
                    "<th>Password</th>"+
                    "<th>Edad</th>"+
                    "<th>Edad2</th>"+
                    "<th>Sexo</th>"+
                    "<th>Direccion</th>"+
                    "<th>Fecha Creacion</th>"+
                    "<th>Fecha Modificacion</th>"+
                    "<th>Opciones</th>"+
                "</tr>";
            parsed.forEach(element => {
                cadena+=
                "<tr>"+
                    "<td>"+element.id+"</td>"+
                    "<td>"+element.nombre+"</td>"+
                    "<td>"+element.email+"</td>"+
                    "<td>"+element.passwd+"</td>"+
                    "<td>"+element.fecha_nacimiento+"</td>"+
                    "<td>"+date+"</td>"+
                    "<td>"+element.sexo+"</td>"+
                    "<td>"+element.direccion+"</td>"+
                    "<td>"+element.fecha_creacion+"</td>"+
                    "<td>"+element.fecha_modificacion+"</td>"+
                    "<td>"+
                        "<div class='row justify-content-center'>"+
                            "<div class='col'>"+
                                "<button class='btn btn-success btn-sm' type='button' onclick='editUserModal(\""+element.id+"\");'><i class='fa fa-edit'></i></button>"+
                            "</div>"+
                            "<div class='col'>"+
                                "<button class='btn btn-danger btn-sm' type='button' onclick='removeUser(\""+element.id+"\");'><i class='fa fa-times'></i></button>"+
                            "</div>"+
                        "</div>"+
                    "</td>"+
                "</tr>";
                
            })
            cadena += "</table>";
            $("#tablaUsuarios").html(cadena)

            
            $(".apuesta_porcentaje").change(function(){
                let elemento = $(this)
                let res = (elemento[0].id).split("_")
                let id = res[1]
                let dinero_actual = $("#dinero_"+res[1]).html()
                $("#apostado_"+res[1]).html( dinero_actual*((elemento[0].value)/100) )
            })
        }
    })
    
}

function editUserModal(id){

    $.ajax({
        url:'controller/usuarioController.php',
        data: {
            "id_usuario": id,
            "accion": "show",
            "dataUsuario": true
        },
        beforeSend: function(objeto){
            //$("#respuestaCrearUsuario").html("<img src='../imagenes/loader.gif'>");
        },
        success:function(data){
            console.log(data)
            var parsed = JSON.parse(data)
            $("#usuario_edit").val(parsed[0].usuario)
            $("#id_edit").val(parsed[0].id)
            $("#modalEditarUsuario").modal("show")
        }
    })
}

$("#botonModalEditarUsuario").click(function(){

    $.ajax({
        url:'controller/usuarioController.php',
        data: {
            "id_usuario": id_edit.value,
            "usuario": usuario_edit.value,
            "dinero": dinero_edit.value,
            "accion": "edit",
            "dataUsuario": true
        },
        beforeSend: function(objeto){
            //$("#respuestaCrearUsuario").html("<img src='../imagenes/loader.gif'>");
        },
        success:function(data){
            if (data == 1){
                $("#modalEditarUsuario").modal("hide")
                mostrarTabla()
            }
        }
    })
})

function removeUser(id){
    if (confirm('¿Estas seguro de eliminar este usuario de la base de datos?')){
        $.ajax({
            url:'controller/usuarioController.php',
            data: {
                "id_usuario": id,
                "accion": "remove",
                "dataUsuario": true
            },
            beforeSend: function(objeto){
                //$("#respuestaCrearUsuario").html("<img src='../imagenes/loader.gif'>");
            },
            success:function(data){
                
                if (data == 1){
                    mostrarTabla()
                }
            }
        })
    }
}

$("#botonApostar").click(function(){
    let arrayApuesta = $(".apuesta_color")
    let arrayDineroApostado = $(".dineroApostado")
    let objApuesta = {}
    
    for (let i = 0; i < arrayApuesta.length; i++) {
        objApuesta[arrayApuesta[i].id] = [arrayApuesta[i].value, arrayDineroApostado[i].innerHTML]
    }
    
    $.ajax({
        url:'controller/apuestaController.php',
        data: {
            "apuesta": objApuesta,
            "accion": "calcularApuesta",
            "dataApuesta": true
        },
        beforeSend: function(objeto){
            //$("#respuestaCrearUsuario").html("<img src='../imagenes/loader.gif'>");
        },
        success:function(data){
            //console.log(data)
            switch (data) {
                case "negro":
                    $("#respuestaColor").html("<div class='box black'></div> Ganó Negro")
                break;
                case "verde":
                    $("#respuestaColor").html("<div class='box green'></div> Ganó Verde")
                break;
                case "rojo":
                    $("#respuestaColor").html("<div class='box red'></div> Ganó Rojo")
                break;
            }
            mostrarTabla()
        }
    })
})

$("#botonLimpiar").click(function(){
    $("#respuestaColor").html("")
})