<template>
    <div>
    <ShareNetwork
    network="facebook"
    :url="`http://lara-auth.ru/ads/${url}`"
    :title="title"
    :description="desc"
>
    Share on Facebook
</ShareNetwork>

    <ShareNetwork
    network="vk"
    :url="`http://lara-auth.ru/ads/${url}`"
    :title="title"
    :description="desc"

>
    Share on vk
</ShareNetwork>
        <ShareNetwork
    network="telegram"
    :url="`http://lara-auth.ru/ads/${url}`"
    :title="title"
    :description="desc"

>
    Share on tele
</ShareNetwork>
    </div>
</template>
<script>
    import VueSocialSharing from 'vue-social-sharing'
    Vue.use(VueSocialSharing);
    export default {
        props:{
          title: '',
          desc:'',
          url:''
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>