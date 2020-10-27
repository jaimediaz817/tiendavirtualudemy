<template>
    <div>

        <div class="login-logo">
            <router-link to="{ name: 'login' }">
                <b>Iniciar sesión</b>
            </router-link>
            <!-- <a href="../../index2.html"><b>Iniciar sesión</b></a> -->
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Ingresa tus credenciales para iniciar sesión</p>

                <form method="post">
                    <div class="input-group mb-3">
                        <input v-model="fillLogin.cEmail" @keyup.enter="login" type="email" class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input v-model="fillLogin.cContrasena" @keyup.enter="login" type="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

            
                </form>

                <div class="row">
                    <div class="col-md-12">
                        <span v-if="error">
                            <div
                                v-for="(e, index) in mensajeError" :key="index"
                                v-text="e"
                                class="callout callout-danger"
                            >

                            </div>
                        </span>
                    </div>
                </div>

                <div class="social-auth-links text-center mb-3">
                    <button class="btn btn-flat btn-block btn-danger" @click.prevent="login" v-loading.fullscreen.lock="fullscreenLoading">
                        Iniciar sesión
                    </button>
                </div>
                <!-- /.social-auth-links -->

            </div>
            <!-- /.login-card-body -->
        </div>

    </div>
</template>

<script>
export default {
    data() {
        return {
            fillLogin: {
                cEmail: '',
                cContrasena: '',
            },
            fullscreenLoading: false,
            error: 0,
            mensajeError: [],
            listRolPermisosByUsuario: [],
            listRolPermisosByUsuarioFilter: [],
        }
    },
    methods: {
        login() {
            if (this.validarLogin()) {
                return;
            }

            this.fullscreenLoading = true;
            var url = "/authenticate/login";

            axios.post(url, {
                    'cEmail'        : this.fillLogin.cEmail,
                    'cContrasena'   : this.fillLogin.cContrasena
            }).then( response => {
                console.log("USUARIO AUTENTICADO: " , response.data);

                if (response.data.code == 401) {
                    this.loginFailed();
                }
                if (response.data.code == 200) {
                    //this.loginSuccess();
                    this.getListarRolPermisosByUsuario(response.data.authUser);
                }

                this.fullscreenLoading = false;
            })
        },

        // Refactorizado
        getListarRolPermisosByUsuario(authUser)
        {
            //var ruta = '/administracion/usuario/getListarRolPermisosByUsuario'
            var ruta = '/administracion/usuario/getListarPermisosByUsuario';
            axios.get(ruta, {
                params: {
                    'nIdUsuario': authUser.id
                }
            }).then( response => {
                console.log("### Login - component - inicial: response.data: ", response)
                this.listRolPermisosByUsuario = response.data;
                this.filterListarRolPermisosByUsuario(authUser);
            })
        },

        loginSuccess(){
            this.$router.push({ name: 'dashboard.index'});
            location.reload();
        }, 

        loginFailed(){
            this.error = 0;
            this.mensajeError = [];

            this.mensajeError.push('Estas credenciales no coinciden con nuestros registros')
            this.fillLogin.cContrasena = '';

            if (this.mensajeError.length) {
                this.error = 1;
            }

            return this.error;   
        },

        validarLogin() {
            this.error = 0;
            this.mensajeError = [];

            if (!this.fillLogin.cEmail) {
                this.mensajeError.push('El correo electrónico es un campo obligatorio')
            }

            if (!this.fillLogin.cContrasena) {
                this.mensajeError.push('La contraseña es un campo obligatorio')
            }            

            if (this.mensajeError.length) {
                this.error = 1;
            }

            return this.error;
        },

        filterListarRolPermisosByUsuario(authUser)
        {            
            var me = this;
            me.listRolPermisosByUsuarioFilter = [];

            me.listRolPermisosByUsuario.map( function(x, y){
                if (x.checked == 1 || x.checked == 1) {
                    me.listRolPermisosByUsuarioFilter.push(x.slug);
                }
            });

            // Guardando en el Session Storage
            sessionStorage.setItem('listRolPermisosByUsuario', 
                JSON.stringify(me.listRolPermisosByUsuarioFilter)
            );

            // Guardando la session del usuario (datos del usuario autenticado)
            sessionStorage.setItem('authUser', 
                JSON.stringify(authUser)
            );            

            this.loginSuccess();
        },        

    }
}
</script>

<style>

</style>