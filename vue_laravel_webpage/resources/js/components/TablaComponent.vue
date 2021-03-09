<template>
    <div>
        <div class="container">
            <div class="row justify-content-center">
                <table class="table table-striped">
                    <thead>
                        <tr class="table-active">
                            <th scope="col">ID</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Edad</th>
                            <th scope="col">Sexo</th>
                            <th scope="col">Direccion</th>
                            <th scope="col">Fecha Creacion</th>
                            <th scope="col">Fecha Modificacion</th>
                            <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody id="bodyTable">
                        <tr class="" v-for="(user, index) in users" :key="index">
                            <th scope="row">{{user.id}}</th>
                            <td>{{user.nombre}}</td>
                            <td>{{user.email}}</td>
                            <td>{{user.edad}}</td>
                            <td>{{user.sexo}}</td>
                            <td>{{user.direccion}}</td>
                            <td>{{user.created_at}}</td>
                            <td>{{user.updated_at}}</td>
                            <td>
                                <div class="row justify-content-center">
                                    <div class="col">
                                        <!-- <button class="btn btn-success btn-sm" type="button" @click="mostrarUser(user.id);" data-toggle="modal" data-target="#ModalUsers"><i class="fa fa-edit"></i></button> -->
                                        <button class="btn btn-success btn-sm" type="button" @click="[titleModal = 'Editar Usuario', actionModal = 'edit', userModal=mostrarUser(user.id)]" data-toggle="modal" data-target="#ModalUsers"><i class="fa fa-edit"></i></button>
                                        <button class="btn btn-danger btn-sm" type="button" @click="removeUser(user.id);"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- <button type="button" id="buttonModalCreate" class="btn btn-primary" data-toggle="modal" data-target="#createModal">Crear Usuario</button> -->
                <!-- <button id="buttonModalCreate" @click="showModal = true" class="btn btn-primary" data-toggle="modal" data-target="#createModal">Crear Usuario</button> -->
                <button id="buttonModalCreate" @click="[titleModal = 'Crear Usuario', actionModal = 'create']" class="btn btn-primary" data-toggle="modal" data-target="#ModalUsers">Crear Usuario</button>
            </div>
        </div>
        <modal-component :title="titleModal" :action="actionModal" :user="userModal" @newUser="users.push($event)" @editedUser="editedUser($event)"> <!-- Cuando el componente hijo emita el evento "newUser", guardaremos en nuestra variable "users" lo que nos tiere el evento (en este caso un objeto con la informacion del nuevo usuario creado) -->
            Esto es un slot <!-- Esto lo capturo en el componente con la etiqueta <slot> -->
        </modal-component>
    </div>
</template>

<script>
export default {
    data(){
        return {
            users : [],
            titleModal : '',
            actionModal : '',
            userModal : {}
        }
    },
    created(){ // Se llama esta función (estándar de Vue) una vez el componente se ha creado y la instancia también (esto es posterior a mounted y el componente no se ha renderizado ni añadido al DOM, esa renderización se hace entre "beforeMount" y "mounted")
        axios.get("/home")
        .then(res => {
            this.users = res.data
        })
    },
    methods: {
        editedUser(id){

            this.mostrarUser(id, () => { // Consulto el usuario basado en la ID y paso un callback que será llamado después de que ya se tenga la respuesta del usuario consultado
                let userId = this.users.findIndex(user => user.id == id) // Encuentro del Index del objeto "user.id"

                // Una vez tengo el ID del usuario en concreto, dentro del array "users", modifico todos los atributos del elemento dentro de "users" para que se actualice su información en el DOM reactivamente
                this.users[userId].nombre = this.userModal.nombre
                this.users[userId].email = this.userModal.email
                this.users[userId].edad = this.userModal.edad
                this.users[userId].sexo = this.userModal.sexo
                this.users[userId].direccion = this.userModal.direccion

            })
        },
        mostrarUser(id, callback = ()=>{} ){ // Inicializo el callback a una función vacia, en caso de que al llamar a esta función no pase ningún callback. Este callback se ejecutará después de toda la lógica escrita en la función, se llamará cuando se requiera
            axios({
                url: '/home',
                method: 'get',
                responseType: 'json',
                params:{
                    "id_user": id
                }
            })
            .then((res) => {
                if(res.status==200) {
                    return res.data
                }
                console.log(res);
                
            })
            .catch((error) => {
                console.log('Error de conexión ' + error);
            })
            .then((res) => {
                this.userModal = res
                callback()
            })
            return this.userModal
            
        },
        removeUser(id){
            if (confirm('¿Está seguro de eliminar este usuario?')){
                axios({
                    url: `/home/${id}`,
                    method: 'delete', // Con este método llamamos la función "destroy" de HomeController
                    responseType: 'json',
                })
                .then((res) => {
                    if(res.status==200) {
                        return res.data
                    }
                    console.log(res);
                    
                })
                .catch((error) => {
                    console.log('Error de conexión ' + error);
                })
                .then((res) => {
                    console.log(res)
                    if(res === 1){
                        let userId = this.users.findIndex(user => user.id == id) // Encuentro del Index del objeto "user.id"
                        this.users.splice(userId, 1) // Borre el elemento(objeto) con ID "id" del array "notas" y borre sólo un elemento
                    }
                })
            }
        }
    },
    /*
    mounted(){ // Esto hace parte del ciclo de vida de Vue, esto se ejecutará cuando el DOM esté completamente renderizado
        this.$emit('ModalUsers', 'create') // emitimos un evento llamado "nombreHijo". Se emitirá la variable "nombre" una vez que el DOM está completamente montado.
    }
    */
}
</script>