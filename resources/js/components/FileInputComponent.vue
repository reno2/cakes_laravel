<template>
    <div>
        <div class="form-group row justify-content-md-center">
            <div class="offset-md-4 col-md-6 mr-2">
                <div v-if="url" class="file-preview">
                    <img class="file-preview__img" v-if="url" :src="url"/>
                    <span class="file-preview__del"></span>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="ava" class="col-md-4 col-form-label text-md-right">Аватарка</label>
            <input @change="loadImg($event)" type="file" id="ava" name="image">
            <div class="col-md-6">
                <button @click="openInput" type="button" class="btn btn-primary btn-block">Загрузить</button>
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
        border-radius: 100px;
        border: 17px solid #eee;
        padding: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .file-preview__img{
        width: 100%;
    }

</style>
