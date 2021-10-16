<template>
    <div class="direct-chat-messages" ref="bajarScroll">
        <template v-if="contacto">
            <!-- Message. Default to the left -->
            <div
                class="direct-chat-msg"
                v-for="(item, index) in mensajes"
                :key="index"
                :class="(item.to == contacto.id) ? '' : 'right' "
            >
                <div class="direct-chat-infos clearfix">
                    <span
                        class="direct-chat-name"
                        :class="(item.to == contacto.id) ? 'float-left' : 'float-right' "
                        v-text="item.user_from_fullname"
                    ></span>
                    <span
                        class="direct-chat-timestamp"
                        :class="(item.to == contacto.id) ? 'float-right' : 'float-left' "
                    >
                    {{ moment(item.created_at).format("dddd, MMMM Do YYYY, h:mm:ss a") }}
                    </span>
                </div>
                <!-- /.direct-chat-infos -->
                <img
                    class="direct-chat-img"
                    src="/img/user1-128x128.jpg"
                    alt="message user image"
                    v-if="!item.user_from_profile_image"
                >
                <img
                    class="direct-chat-img"
                    alt="message user image"
                    v-else
                    :src="item.user_from_profile_image"
                >
                <!-- /.direct-chat-img -->
                <div class="direct-chat-text">
                    {{ item.text }}
                </div>
                <!-- /.direct-chat-text -->
            </div>
            <!-- /.direct-chat-msg -->

            <!-- Message to the right -->
            <!-- <div class="direct-chat-msg right">
                <div class="direct-chat-infos clearfix">
                    <span class="direct-chat-name float-right">Sarah Bullock</span>
                    <span class="direct-chat-timestamp float-left">23 Jan 2:05 pm</span>
                </div>
                <img class="direct-chat-img" src="/img/user3-128x128.jpg" alt="message user image">
                <div class="direct-chat-text">
                    You better believe it!
                </div>
            </div> -->
            <!-- /.direct-chat-msg -->
        </template>

        <template v-else>
            <div class="direct-chat-msg">
                <vs-alert shadpw>
                    <template #title>
                        Mensaje
                    </template>
                    Debe seleccionar un contacto para iniciar una conversación
                </vs-alert>
            </div>
        </template>
    </div>
</template>

<script>
    export default {
        props: {
            mensajes: {
                type: Array,
                default: []
            },
            contacto: {
                type: Object,
                default: null
            }
        },
        data() {
            return {
                moment: moment,
            }
        },
        watch: {
            // escuchar cambios en el props mensajes que llega
            mensajes() {
                this.scrollToBottom();
            },
            contacto() {
                this.scrollToBottom();
            },
        },
        methods: {
            scrollToBottom() {
                setTimeout(() => {
                    this.$refs.bajarScroll.scrollTop = this.$refs.bajarScroll.scrollHeight - this.$refs.bajarScroll.clientHeight
                }, 100);
            }
        }
    }
</script>

<style>

</style>
