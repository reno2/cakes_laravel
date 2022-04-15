<template>
    <div class="m-menu">
        <transition name="fade">
            <div v-if="isOpen" class="m-menu__overlay" @click="openMenu"></div>
        </transition>
        <transition name="slide-left-fade">
            <div v-if="isOpen" class="m-menu__main">
                <div class="m-menu__inner">
                    <div class="m-menu__top"></div>
                    <div class="m-menu__middle menu">
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
            menu: {type: String}
        },
        data() {
            return {
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
        display: block;
        font-size: 14px;
        line-height: 1.8;
        padding: 12px 16px 12px 36px;
        text-decoration: none;
    }
    .m-menu__close{
        width: 24px;
        height: 24px;
    }
</style>