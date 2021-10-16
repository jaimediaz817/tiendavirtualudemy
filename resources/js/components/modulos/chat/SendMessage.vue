<template>
    <form action="#" method="post">
        <div class="input-group">
            <button
                @click="toogleDialogEmoji"
                :readonly="(!contacto) ? true : false"
                type="button"
            >😃</button>
            <input
                type="text"
                name="message"
                placeholder="Escriba un mensaje..."
                class="form-control"
                v-model="message"
                @keydown.enter.prevent="setRegistrarMensaje"
                @keydown="setEscribiendoMensaje"
                :readonly="(!contacto) ? true : false"
            >
            <span class="input-group-append">
                <button
                    type="button"
                    class="btn btn-primary"
                    @click.prevent="setRegistrarMensaje"
                    :readonly="(!contacto) ? true : false"
                >Enviar</button>
            </span>
        </div>

        <VEmojiPicker
            v-show="showDialog"
            :style="{ width: '440px', height: '200' }"
            labelSearch="Search"
            lang="pt-BR"
            @select="onSelectEmoji"
        />

    </form>
</template>

<script>
    import { VEmojiPicker, emojisDefault, categoriesDefault } from "v-emoji-picker";
    export default {
        components: {
            VEmojiPicker
        },
        props: {
            contacto: {
                type: Object,
                default: null
            },
            usuario: {
                type: Object,
                default: null
            },
        },
        data() {
            return {
                message: '',
                showDialog: false,

            }
        },
        methods: {
            setRegistrarMensaje() {
                console.log("evento click o keydown");

                if ( !this.message ) {
                    return
                }

                if ( !this.contacto ) {
                    return
                }

                // Registrar mensaje
                var url = '/chat/setRegistrarMensaje';
                axios.post(url, {
                    'nIdContacto': this.contacto.id,
                    'cMensaje'   : this.message
                }).then( respuesta => {
                    // emitir evento - caso success
                    this.$emit('mensaje', respuesta.data[0]);
                    this.message = '';
                });
            },

            setEscribiendoMensaje()
            {
                if ( !this.message ) {
                    return
                }

                if ( !this.contacto ) {
                    return
                }

                // Escuchar el canal:  escribiendo | whisper
                // usuario autenticado, usuario al que le estamos escribiendo
                Echo.private('escribiendo')
                    .whisper('typing', {
                        usuario:  this.usuario.id,
                        contacto: this.contacto.id,
                        typing:   true
                    })
            },

            onSelectEmoji(emoji) {
                // this.valueInput += emoji.data;
                console.log(emoji);
                // Optional
                // this.toogleDialogEmoji();
                this.message += emoji.data;
            },

            toogleDialogEmoji() {

                if ( !this.contacto ) {
                    return
                }

                console.log("Toogle!");
                this.showDialog = !this.showDialog;
            },
        }
    }
</script>

<style>

</style>
