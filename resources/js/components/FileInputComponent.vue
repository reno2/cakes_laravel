<template>
    <div class="file-input">
        <div class="form-group__single form-group file-input__top">
            <div class="file-input__figure">
                <div v-if="url" class="file-preview file-input__preview">
                    <img class="js_profileAva file-preview__img" v-if="url" :src="url"/>

                    <svg v-if="hasAvatar == true" @click="removeAva" class="file-preview__del">
                        <use xlink:href="/images/icons.svg#icon-close"></use>
                    </svg>
                </div>
            </div>
        </div>
        <div class="form-group file-input__actions">
            <label for="ava" class="form-group__placeholder file-input__label">Аватарка</label>
            <div class="form-group__inputs">
                <input @change="loadImg($event)" type="file" id="ava" name="image">
                <div class="file-input__btn">
                    <button @click="openInput" type="button" class="btn-middle btn-grey wide">Загрузить</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            profileId: {
                type: String,
            },
            img: {
                type: String
            },
            token: {type: String},
            hasAvatar: {type: String},
        },
        data() {
            return {
                defaultAva: '/storage/images/defaults/cake.svg',
                input: null,
                url: null,
            };
        },
        methods: {
            async removeAva() {
                const that = this;
                const response = await axios.delete(`/profile/avatar/remove/${that.profileId}`,
                    {
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'Authorization': 'Token ' + that.token
                        }
                    }
                );
                if (response.data.success) {
                    document.querySelectorAll('.js_profileAva').forEach((el, i) => {
                        el.src = this.defaultAva;
                        this.hasAvatar = false;
                    });
                }
            },
            loadImg(event) {
                let file = event.target.files[0];
                this.url = URL.createObjectURL(file);
            },
            openInput() {
                this.input.click();
            }
        },
        mounted() {
            if (this.img) this.url = this.img;
            this.input = document.getElementById('ava');
        }
    };
</script>
<style>
    #ava {
        display: none
    }
    .file-preview {
        border-radius: 8px;
        width: 200px;
        height: 200px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }
    .file-preview__img {
        object-fit: cover;
        object-position: top;
        height: 100%;
    }
    .file-preview__del {
        width: 30px;
        height: 30px;
        fill: #bf4141;
        position: absolute;
        z-index: 9;
        bottom: 0;
        right: 0;
        background: #ffffff;
        padding: 3px;
        cursor: pointer;
        border-radius: 2px;
    }
    .file-input__top {

    }
    .file-preview__del:hover {
        background: #eeeeee;
    }
    .file-input {
        margin-bottom: 24px;
    }
    .file-input__actions {
        display: flex;
        align-items: center;
    }
    .file-input__label {

    }

    @media (max-width: 767px) {
        .file-input .file-preview {
            height: 150px;
            width: 150px;
        }
       .file-input .file-input__top{
            margin-left: 0;
            display: flex;
            justify-content: center;
            padding-left: 0;
            align-items: center;
        }
    }
</style>
