<template>
    <div class="direct-chat-contacts">
        <ul class="contacts-list">
            <li v-for="(item, index) in contactos" :key="index">
                <a href="#">
                    <img v-if="!item.profile_image" class="contacts-list-img" src="/img/user1-128x128.jpg" alt="User Avatar">
                    <img v-else class="contacts-list-img" :src="item.profile_image" alt="User Avatar">
                    <div class="contacts-list-info">
                        <span class="contacts-list-name">
                            {{ item.fullname }}
                            <small class="contacts-list-date float-right">2/28/2015</small>
                        </span>
                        <span class="contacts-list-msg">How have you been? I was...</span>
                    </div>
                    <!-- /.contacts-list-info -->
                </a>
            </li>
            <!-- End Contact Item -->
        </ul>
        <!-- /.contacts-list -->
    </div>
</template>

<script>
    export default {
        props: {
            contactos: {
                type: Array,
                default: []
            }
        }
    }
</script>

<style>

</style>
