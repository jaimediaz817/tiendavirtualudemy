<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Dashboard</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="content container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <router-link class="btn btn-info btn-sm" :to="'/'">
                            <i class="fas fa-arrow-left"></i>
                            Regresar
                        </router-link>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <Graphic></Graphic>
                    </div>
                </div>

                <!-- CHAT  -->
                <div class="card-body">
                    <div class="container-fluid">
                        <Chat></Chat>
                    </div>
                </div>
                <!--/ CHAT -->

            </div>
        </div>
    </div>
</template>

<script>
    import Graphic from './Graphic'
    import Chat from '../chat/Chat.vue';
    export default {
        components: {
            Graphic,
            Chat
        },
        data() {
            return {

            }
        },
        mounted() {

        },
        methods: {

        }
    }
</script>

<style>

</style>
