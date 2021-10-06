<template>
    <div class="row">
        <div class="col-md-6">
            <div class="card direct-chat direct-chat-primary">
                <div class="card-header ui-sortable-handle" style="cursor: move;">
                    <h3 class="card-title">Mensajes Instantáneos</h3>
                    <div class="card-tools">
                        <span title="3 New Messages" class="badge badge-primary">3</span>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" title="Contacts" data-widget="chat-pane-toggle">
                            <i class="fas fa-comments"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <!-- /.card-header -->
                <div class="card-body">
                    <!-- Conversations are loaded here -->
                    <Conversation></Conversation>
                    <!--/.direct-chat-messages-->

                    <!-- Contacts are loaded here -->
                    <ContactList :contactos="listContactos"></ContactList>
                    <!-- /.direct-chat-pane -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <SendMessage></SendMessage>
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
        components: {
            Conversation,
            ContactList,
            SendMessage
        },
        data() {
            return {
                listContactos: [],
            }
        },
        methods: {
            getListarContactos() {
                var url = '/chat/getListarContactos';
                axios.get(url).then( response => {
                    this.listContactos = response.data;
                })
            }
        },
        mounted() {
            this.getListarContactos();
        }
    }
</script>

<style>

</style>
