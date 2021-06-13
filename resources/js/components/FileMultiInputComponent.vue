<template>
    <div class="form-group row">
        <label class="col-md-4 col-form-label text-md-right">Изображения</label>
        <div class="col-md-7 p-0 create-form__right">
                <div class="create-form__title">Основная картинка<br>
                    Загрузите свои изображения<br>
                    не более 5 файлов. (jpeg, png)
                </div>

                <div class="form-group single-img__group">
                    <input multiple name="image[]" type="file" id="file_" value=""
                           data-count="0" class="js_fileInput single-img__input">
                    <div class="create-form__error"></div>
                </div>
            <input type="hidden" name="main_image" id="main_image">
            <div id="image-list" class="create-form__preview image-preview">
                <div class="fake-upload">
                    <img class="fake-upload__img" src="" alt="">
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            img: {
                type: String
            }
        },
        data() {
            return {
                input: null,
                url: null
            }
        },
        methods: {
            loadImg(event) {
                let file = event.target.files[0]
                this.url = URL.createObjectURL(file);
                // let reader = new FileReader();
                // reader.onload = (el) => {
                //
                // }
                // reader.readAsDataURL(el);
            },
            openInput() {
                this.input.click()
            }
        },
        mounted() {
            if(this.img) this.url = this.img
            this.input = document.getElementById('ava');
        }
    }
</script>
<style>
    #ava {
        display: none
    }
    .file-preview{
        width: 200px;
        height: 200px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .file-preview__img{
        width: 100%;
    }

</style>
