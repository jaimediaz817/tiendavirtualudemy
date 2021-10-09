<template>
    <div class="row">
        <div class="col-md-6">
            <div
                class="card direct-chat direct-chat-primary"
                :class="(openToCloseContact) ? 'direct-chat-contacts-open' : ''"
            >
                <div class="card-header ui-sortable-handle" style="cursor: move;">
                    <h3 class="card-title">Mensajes Instantáneos</h3>
                    <div class="card-tools">
                        <span title="3 New Messages" class="badge badge-primary">{{ totalMensajesNoLeidos }}</span>
                        <button
                            type="button"
                            class="btn btn-tool"
                            data-card-widget="collapse"
                        >
                            <i class="fas fa-minus"></i>
                        </button>
                        <button
                            type="button"
                            class="btn btn-tool"
                            title="Contacts"
                            @click.prevent="abrirContactos"
                        >
                            <i class="fas fa-comments"></i>
                        </button>
                    </div>
                </div>

                <!-- /.card-header -->
                <div class="card-body">
                    <!-- Conversations are loaded here -->
                    <Conversation
                        :mensajes="listMensajes"
                        :contacto="selectedContact"
                    ></Conversation>
                    <!--/.direct-chat-messages-->

                    <!-- Contacts are loaded here -->
                    <ContactList
                        :contactos="listContactos"
                        @contacto="getListarConversaciones"
                        :typing="userTyping"
                    ></ContactList>
                    <!-- /.direct-chat-pane -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <SendMessage
                        @mensaje="setNuevoMensaje"
                        :contacto="selectedContact"
                        :usuario="usuario"
                    ></SendMessage>
                </div>
            <!-- /.card-footer-->
            </div>
        </div>
    </div>
</template>

<script>

    import Conversation from './Conversation'
    import ContactList from './ConcatList'
    import SendMessage from './SendMessage'

    export default {
        props: ['usuario'],
        components: {
            Conversation,
            ContactList,
            SendMessage
        },
        data() {
            return {
                listContactos:   [],
                listMensajes:    [],
                selectedContact: null,
                openToCloseContact: false,

                // CHAT
                userTyping: {
                    usuario: 0,
                    state: false
                }
            }
        },
        computed: {
            totalMensajesNoLeidos() {
                // return
                return this.listContactos.reduce( function( valorAnterior, valorActual){
                    console.log("valores: anteriorl " , valorAnterior, " , siguiente: ", valorActual)
                    return valorAnterior + parseFloat(valorActual.nNumeroMensajesNoLeidos)
                } ,0)
            },
        },
        methods: {
            abrirContactos() {
                this.openToCloseContact = !this.openToCloseContact;
            },
            getListarContactos() {
                var url = '/chat/getListarContactos';
                axios.get(url).then( response => {
                    this.listContactos = response.data;
                });
            },

            // EMMIT
            setNuevoMensaje(respuesta)
            {
                console.log("respuesta: ", respuesta)
                this.listMensajes.push(respuesta);
            },

            getListarConversaciones(contacto)
            {
                // abrir/cerrar ventana de contactos
                this.abrirContactos();

                var url = '/chat/getListarConversaciones';
                axios.get(url, {
                    params: {
                        'nIdContacto':  contacto.id
                    }
                }).then( response => {
                    this.listMensajes    = response.data;
                    this.selectedContact = contacto;

                    // actualizar lista de conversaciones leídas
                    this.getListarContactos();
                });
            },

            setMensajeEntrante(mensaje) {
                if (this.selectedContact && this.selectedContact.id == mensaje.from)
                {
                    this.setNuevoMensaje(mensaje);
                }

                // Notificación sonora:
                var sound = new How({
                    src: ['/ringtone/notificacion_chat.mp3']
                });
                sound.play();

                // Notificar
                const noti = this.$vs.notification({
                    square: true,
                    color: 'rgb(59,222,200)',
                    position: 'bottom-right',
                    title: mensaje.user_from_fullname,
                    text: mensaje.text
                })

                // actualizar lista de conversaciones leídas
                this.getListarContactos();
            }
        },
        mounted() {
            Echo.private(`mensaje.${this.usuario.id}`)
                .listen('NuevoMensajeChat', (e)=> {
                    console.log("evento echo: ", e);
                    this.setMensajeEntrante(e.mensaje)
                });
            this.getListarContactos();

            Echo.private('escribiendo')
                .listenForWhisper('typing', (e) => {
                    if (this.usuario.id == e.contacto) {
                        this.userTyping.state   = true;
                        this.userTyping.usuario = e.usuario;

                        setTimeout(()=> {
                            this.userTyping.state = false
                        }, 2000);
                    }
                })
        }
    }
</script>

<style>

</style>
