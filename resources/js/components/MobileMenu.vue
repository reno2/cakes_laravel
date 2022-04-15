<template>
    <div class="m-menu">
        <transition name="fade">
            <div v-if="isOpen" class="m-menu__overlay" @click="openMenu"></div>
        </transition>
        <transition name="slide-left-fade">
            <div v-if="isOpen" class="m-menu__main">
                <div class="m-menu__inner">
                    <div v-if="profileMenu" class="m-menu__top" :class="{'m-menu__profile' : profileMenu}">
                        <div class="m-menu__title">Профиль</div>
                        <a :href="profileItem.link" v-for="(profileItem, key) in profile" class="m-menu__link">
                            <svg class="m-menu__icon"><use :xlink:href="profileItem.icon"></use></svg>
                            {{profileItem.title}}
                        </a>
                    </div>
                    <div class="m-menu__middle menu">
                        <div class="m-menu__title">Разделы</div>
                        <a :href="`/category/${menuItem.slug}`" v-for="menuItem in JSON.parse(menu)" class="m-menu__link">{{menuItem.title}}</a>
                    </div>
                </div>
                <div class="m-menu__button" @click="openMenu">
                    <svg class="m-menu__close">
                        <use xlink:href="/images/icons.svg#icon-close"></use>
                    </svg>
                </div>
            </div>
        </transition>
</div>
</template>

<script>
    //import request from '../request';

    export default {
        props: {
            menu: {type: String},
            profileMenu: false
        },
        data() {
            return {
                profile: [
                    {
                        'link' : '/',
                        'title' : 'На главную',
                        'icon' : '/images/icons.svg#icon-home'
                    },
                    {
                        'link' : '/profile/ads/create',
                        'title' : 'Создать объявление',
                        'icon'  : '/images/icons.svg#icon-add'
                    },
                    {
                        'link' : '/profile/edit',
                        'title' :'Изменить профиль',
                        'icon'  : '/images/icons.svg#icon-profile'
                    },
                    {
                        'link' : '/profile/secure',
                        'title' :'Изменить пароль',
                        'icon'  : '/images/icons.svg#icon-pass'
                    },
                    {
                        'link' :'/profile/ads',
                        'title' :'Объявления',
                        'icon'  : '/images/icons.svg#icon-ads'
                    },
                    {
                        'link' :'/profile/comments',
                        'title' :'Сообщения',
                        'icon' : '/images/icons.svg#icon-questions'
                    },
                    {
                        'link' :'/profile/favorites',
                        'title' :'Избранное',
                        'icon' :  '/images/icons.svg#icon-questions'
                    }
                ],
                data1: [],
                isOpen: false,
                body: null
            };
        },
        methods: {
            openMenu({target}) {
                this.isOpen = !this.isOpen;
                (this.isOpen) ? this.body.classList.add('scrollBlock') : this.body.classList.remove('scrollBlock');
            },
            onResize() {
               window.innerWidth > 767 ? this.isOpen = false : ''

            }
        },
        mounted() {
            document.querySelector('.js_mobile__menu').addEventListener('click', this.openMenu);
            this.body = document.body;
            this.$nextTick(() => {
                window.addEventListener('resize', this.onResize);
            })
        },
        beforeDestroy() {
            window.removeEventListener('resize', this.onResize);
        },
    };
</script>
<style>
    .m-menu__overlay {
        background: rgba(0, 0, 0, .2);
        height: 100vh;
        position: fixed;
        z-index: 1001;
        width: 100%;
        right: 0;
        top: 0;
    }
    .m-menu.open {
        background: rgba(0, 0, 0, .2);
        height: 100vh;
        position: fixed;
        z-index: 1002;
        width: 100%;
    }
    .m-menu__main {
        background-color: #ffffff;
        bottom: 0;
        box-shadow: 0 16px 16px rgb(0 0 0 / 24%), 0 0 16px rgb(0 0 0 / 18%);
        display: flex;
        flex-direction: row;
        flex-grow: 1;
        left: 0;
        max-width: 320px;
        overflow: scroll;
        position: fixed;
        top: 0;
        width: 85%;
        z-index: 1001;
    }
    .m-menu__inner{
        width: 100%;
        margin-top: 24px;
    }
    .m-menu__button{
        padding: 16px;
    }
    .m-menu__middle {
        padding-top: 8px;
    }
    .m-menu__link {
        color: #212121;
        display: flex;
        font-size: 14px;
        line-height: 1.8;
        padding: 12px 16px 12px 36px;
        text-decoration: none;
        align-items: center;
    }
    .m-menu__close{
        width: 24px;
        height: 24px;
    }

    .m-menu__title{
        font-weight: 900;
        margin-left: 36px;
        font-size: 12px;
        border-bottom: 1px solid #eee;
        padding-bottom: 8px;
    }

    /* region If profile  */
    .m-menu__profile{
        margin-bottom: 24px;
    }
    .m-menu__icon{
        width: 16px;
        height: 16px;
        margin-right: 8px;
        fill: #a7a7a7;
    }

</style>