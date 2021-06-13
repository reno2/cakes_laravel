<template>
    <div>
        <div class="form-group row justify-content-md-center">
            <div class="offset-md-4 col-md-6 mr-2">
                <div v-if="url" class="file-preview">
                    <img class="js_profileAva file-preview__img" v-if="url" :src="url"/>

                    <svg v-if="hasAvatar == true" @click="removeAva" class="file-preview__del">
                        <use xlink:href="/images/icons.svg#icon-close"></use>
                    </svg>
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
            profileId: {
                type: String,
            },
            img: {
                type: String
            },
            token: {type: String},
            hasAvatar: {type : String},
        },
        data() {
            return {
                defaultAva: '/storage/images/defaults/cake.svg',
                input: null,
                url: null,
            }
        },
        methods: {
            async removeAva(){
               const that = this
                const response = await axios.delete(`/profile/avatar/remove/${that.profileId}`,
                    {headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "Authorization": "Token " + that.token
                    }}
                );
               if(response.data.success){
                    document.querySelectorAll('.js_profileAva').forEach((el, i) =>{
                        console.log(el);
                        el.src = this.defaultAva
                        console.log(this);
                        this.hasAvatar = false
                    })

               }
                console.log(response);
            },
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
        border-radius: 8px;
        width: 200px;
        height: 200px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }
    .file-preview__img{
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
        background: #fff;
        padding: 3px;
        cursor: pointer;
        border-radius: 2px;
    }
    .file-preview__del:hover{
        background: #eee;
    }

</style>
