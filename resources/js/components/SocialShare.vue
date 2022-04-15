<template>
    <div class="social">
        <ShareNetwork
            v-for="(network, inx) in networks"
            :key="inx"
            :network="network"
            :url="url"
            :title="title"
            :description="desc"
            :media="`${img}`"
            class="social__item"
        >
            <svg class="social__icon i-svg i-svg__tw i-svg__bgGrey">
                <use :xlink:href='`/icons/social.svg#${network}`'/>
            </svg>
        </ShareNetwork>
    </div>
</template>
<script>
    import VueSocialSharing from 'vue-social-sharing';
    Vue.use(VueSocialSharing);
    export default {
        data: () => ({
            networks: ['telegram', 'vk', 'odnoklassniki']
        }),
        props: {
            title: '',
            desc: '',
            url: '',
            img: ''
        }
    };
</script>
<style>
    .social{
        display: flex;
    }
    .social__item{

    }
    .social__item:not(:first-child){
        margin-left: 8px;
    }
    .social__icon:hover{
        opacity: .6;
    }
</style>