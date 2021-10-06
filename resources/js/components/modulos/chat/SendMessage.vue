<template>
    <form action="#" method="post">
        <div class="input-group">
            <input
                type="text"
                name="message"
                placeholder="Escriba un mensaje..."
                class="form-control"
                v-model="message"
                @keydown.enter.prevent="setEnviarMensaje"
            >
            <span class="input-group-append">
                <button type="button" class="btn btn-primary">Send</button>
            </span>
        </div>
    </form>
</template>

<script>
    export default {
        data() {
            return {
                message: ''
            }
        },
        methods: {
            setEnviarMensaje() {
                if ( !this.message ) {
                    return
                }

                // emitir evento
                this.$emit('mensaje', this.message);
                this.message = '';
            }
        }
    }
</script>

<style>

</style>
