<template>
    <div v-if="title == 'Crear Usuario'">
        <!-- Inicio modal para Crear usuarios -->
        <div class="modal fade" id="ModalUsers" tabindex="-1" role="dialog" aria-labelledby="ModalUsersLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalUsersLabel">{{title}}</h5>
                        <slot></slot>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="createModalBody">
                        <div class="form-group">
                            <label for="nombre_edit" class="col-form-label">Nombre:</label>
                            <input type="text" class="form-control" id="nombre_create">
                        </div>
                        <div class="form-group">
                            <label for="email_edit" class="col-form-label">Correo:</label>
                            <input type="text" class="form-control" id="email_create">
                        </div>
                        <div class="form-group">
                            <label for="edad_edit" class="col-form-label">Edad:</label>
                            <input type="text" class="form-control" id="edad_create">
                        </div>
                        <div class="form-group">
                            <label for="password_edit" class="col-form-label">Password:</label>
                            <input type="password" class="form-control" id="password_create">
                        </div>
                        <div class="form-group">
                            <label for="genero_create" class="col-form-label">Genero:</label>
                            <select name="genero_edit" id="genero_create" class="form-control">
                                <option value="" disabled selected>Seleccione un genero</option>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="direccion_create" class="col-form-label">Direccion:</label>
                            <input type="text" class="form-control" id="direccion_create">
                        </div>
                        <div class="form-group">
                            <span id="response_create"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="buttonCreate" @click="createUser()" class="btn btn-success">Crear</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Final modal para Crear usuarios -->
    </div>

    <div v-else-if="title == 'Editar Usuario'">
        <!-- Inicio modal para Editar usuarios -->
        <div class="modal fade" id="ModalUsers" tabindex="-1" role="dialog" aria-labelledby="ModalUsersLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalUsersLabel">{{title}}</h5>
                        <slot></slot>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <input type="hidden" class="form-control" id="id_edit" :value="user.id">
                    <div class="modal-body" id="editModalBody">
                        <div class="form-group">
                            <label for="nombre_edit" class="col-form-label">Nombre:</label>
                            <input type="text" class="form-control" id="nombre_edit" :value="user.nombre">
                        </div>
                        <div class="form-group">
                            <label for="email_edit" class="col-form-label">Correo:</label>
                            <input type="text" class="form-control" id="email_edit" :value="user.email">
                        </div>
                        <div class="form-group">
                            <label for="edad_edit" class="col-form-label">Edad:</label>
                            <input type="text" class="form-control" id="edad_edit" :value="user.edad">
                        </div>
                        <div class="form-group">
                            <label for="password_edit" class="col-form-label">Password:</label>
                            <input type="password" class="form-control" id="password_edit">
                        </div>
                        <div class="form-group">
                            <label for="genero_edit" class="col-form-label">Genero:</label>
                            <select name="genero_edit" id="genero_edit" class="form-control" :value="user.sexo">
                                <option value="" disabled selected>Seleccione un genero</option>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="direccion_edit" class="col-form-label">Direccion:</label>
                            <input type="text" class="form-control" id="direccion_edit" :value="user.direccion">
                        </div>
                        <div class="form-group">
                            <span id="response_edit"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="buttonUpdate" @click="updateUser(user.id)" class="btn btn-success">Actualizar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Final modal para Editar usuarios -->
    </div>

</template>

<script>
export default {
    // Propiedades sin especificar tipo (se declaran en un Array)
    //props:['title', 'action'],

    // Propiedades especificando su tipo (se declaran dentro d eun objeto)
    props: {
        'title' : {
            type: String,
            required: true
        },
        'action' : {
            type: String,
            required: true
        },
        'user' : {
            type: Object,
            required: false
        }
    },
    data(){
        return {
            //accion:''
        }
    },
    methods: {
        createUser(){
            axios({
                url: '/home',
                method: 'post', // Con "post" contacto el método "store" de HomeController
                responseType: 'json',
                params:{
                    "nombre": nombre_create.value,
                    "email": email_create.value,
                    "edad": edad_create.value,
                    "password": password_create.value,
                    "genero": genero_create.value,
                    "direccion": direccion_create.value
                }
            })
            .then((res) => {
                if(res.status===200 || res.status===201) {
                    return res.data
                }
                console.log(res);
            })
            .catch((error) => {
                console.log('Error de conexión ' + error);
            })
            .then((res) => {
                response_create.innerHTML = 
                    `<div class="alert alert-success" role="alert" class="form-control">
                        Usuario '${res.nombre}' agregado con éxito
                    </div>`
                this.$emit('newUser', res) // Una vez se guarde el registro emitimos un evento al componente padre para que guarde el usuario creado y renderice el nuevo usuario en la tabla reactivamente
            })
        },
        updateUser(id){
            axios({
                url: `/home/${id}`,
                method: 'put', // Con "put" contacto el método "update" de HomeController
                responseType: 'json',
                params:{
                    "nombre": nombre_edit.value,
                    "email": email_edit.value,
                    "edad": edad_edit.value,
                    "password": password_edit.value,
                    "genero": genero_edit.value,
                    "direccion": direccion_edit.value
                }
            })
            .then((res) => {
                if(res.status===200) {
                    return res.data
                }
                console.log(res);
            })
            .catch((error) => {
                console.log('Error de conexión ' + error);
            })
            .then((res) => {
                response_edit.innerHTML = 
                    `<div class="alert alert-success" role="alert" class="form-control">
                        Usuario editado con éxito
                    </div>`
                    this.$emit('editedUser', id) // Una vez se guarde el registro emitimos un evento al componente padre para que guarde el usuario creado y renderice el nuevo usuario en la tabla reactivamente
            })
        },
    },
    beforeCreate(){
        console.log("beforeCreate")
    },
    created(){
        console.log("created")
    },
    beforeMount(){
        console.log("beforeMount")
    },
    mounted(){
        console.log("mounted")
    }
}
</script>