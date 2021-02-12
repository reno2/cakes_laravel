<template>
    <div class="form-group row">
        <div class="mfu__left">
            <div class="mfu__label">Загрузите картинки для объявления</div>
            <div class="mfu__hint"> Загрузите свои изображения не более 5 файлов. (jpeg, png)</div>
        </div>
        <div class="mfu__right">
            <div class="mfu__files">
                <div :class="{'mfu__main' : prop.main}" class="mfu__item" v-for="prop in renderFiles">
                    <img :src="url(prop)" alt="">
                    <svg @click="removeItem(prop.file_name)">
                        <use xlink:href="/images/icons.svg#icon-close"></use>
                    </svg>
                </div>
                <div class="mfu__action">
                    <img class="mfu__btn" src="/images/plus.svg" alt="">
                </div>
            </div>

        </div>

        <ValidationProvider ref="provider" rules="size:200|ext:jpg,png|check_count:5" v-slot="{ errors, validate }">
            <input accept="image/*" multiple type="file" @change="selected">
            <span>{{ errors[0] }}</span>
        </ValidationProvider>


        <input type="hidden" name="to_remove" id="to_remove">
        <input type="hidden" name="make_main" id="main_image">
        <input type="hidden" name="db_main" id="main"  value="">
    </div>
</template>
<script>
    import { ValidationProvider } from 'vee-validate';;
    import '../validators';
    export default {
        props: {
            message: {
                type: String,
                default: ''
            },
            oldFiles: {
                type: String,
                default: null
            },
            dbMain: {
                type: String,
                default: null
            }
        },
        data: () => ({
                name:  'basic-example',
                files: [],
                to_remove: null,
                value: null,
                tmpForMultipleFiles: {},
                addFile: 0
        }),
        computed: {
            renderFiles(){
                console.log(this.addFile)
        
                if(Object.keys(this.tmpForMultipleFiles).length > 0)
                return this.tmpForMultipleFiles
            },
            choosing() {
                // if (this.results.length && this.showList) {
                //     //console.log(this.results)
                //     return this.results
                // }
            }
        },
        components: {
            ValidationProvider
        },
        methods: {
            url(prop){
                return URL.createObjectURL(prop);
            },
            removeItem(name){
                console.log(name)
            },
            validateRule(newFile){

            },
            async selected( e) {
                const that = this
                const valid = await this.$refs.provider.validate(Array.from(e.target.files ));
                if (!valid.valid) {
                    e.target.value = null
                    return;
                }
                Array.from(e.target.files).forEach(file => {
                    if(!that.tmpForMultipleFiles.hasOwnProperty(file.name)) {
                        that.tmpForMultipleFiles[file.name] = file
                        that.addFile +=1
                    }
                })



            },
        },
        mounted() {
            if(this.oldFiles.length){
                this.files = JSON.parse(this.oldFiles)
            }
            //this.to_remove = this
            //console.log(this.$el.querySelector("#to_remove"))
        }
    }
</script>
<style lang="scss">
    .mfu__left{
        flex: 0 0 33.3333333333%;
        max-width: 33.3333333333%;
        text-align: right;
        padding-right: 15px;
        .mfu__hint{
            color: #9e9a9a;
            font-size: 10px;
        }
    }
    .mfu__right{
        padding-left: 15px;
        flex: 0 0 58.3333333333%;
        .mfu__action{
            .mfu__btn{
                cursor: pointer;
                width:100px;
                height: 98px;
                background: #99c793;
                display: block;
                border-radius: 10px;
                padding: 16px;
                box-shadow: 0 4px 0 -1px #83ad7e;
            }
        }
        .mfu__files{
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;
        background: #fff;
        padding: 5px;

        .mfu__item {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 16px;
            border: 4px solid #f8fafc;
            padding: 8px;
            box-shadow: 0 1px 8px -7px #000;
            border-radius: 5px;
            margin-right: 4px;
            width: 100px;
            overflow: hidden;
            max-height: 127px;
            position: relative;
            img{
                width: 100%;
            }
            svg{
                position: absolute;
                width: 20px;
                fill: tomato;
                height: 20px;
                left: 0;
                top: 0;
                background: #ffffff;
                border-radius: 3px;
                &:hover{
                    transform: scale(1.3);
                    cursor:pointer;
                }
            }
        }
    }
    }
</style>
