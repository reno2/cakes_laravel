<template>

    <div class="form-group row" :class="{'onError' : message}">
        <label for="address" class="form-group__placeholder">Город</label>
        <div class="form-group__inputs">
            <input required @blur="unblur" @keyup="fillAddress($event)" autocomplete="off" v-model="city" type="text" id="address"
                   name="address" :class="{'is-invalid' : message}" class="form-group__input">
            <span v-if="message" class="invalid-feedback help-block text-danger">{{ message }}</span>
            <transition name="slide-fade">
                <div v-if="choosing" class="dropdown-menu scrollbar">
                    <a @click="selectCity(item.data.city)" class="dropdown-item" v-for="(item, inx) in choosing" :key="inx">{{item.data.city}}</a>
                </div>
            </transition>
        </div>
    </div>

</template>
<script>
    export default {
        props: {
            message: {
                type: String,
                default: ''
            },
            value: {
                type: String,
                default: ''
            }
        },
        data() {
            return {
                token: '4411ab8ee14736f68ad24c1b445ce5e15fa395b4',
                city: '',
                results: [],
                showList: false
            }
        },
        computed: {
            choosing() {

                if (this.results.length && this.showList) {
                    //console.log(this.results)
                    return this.results
                }
            }
        },
        methods: {
            unblur(){
                this.showList = false
            },
            selectCity(cityVal) {
                this.city = cityVal
                this.showList = false
            },
            fillAddress(event) {
                this.message = ''
                if (this.city.length > 3) {
                    let d = {
                        query: this.city,
                        hint: false,
                        from_bound: {"value": "city"},
                        to_bound: {"value": "city"}
                    }
                    this.getAddress(d)
                }else{
                    this.showList = false
                }
            },
            getAddress(data) {
                const that = this
                axios({
                    method: 'POST',
                    url: 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/address',
                    data: JSON.stringify(data),
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "Authorization": "Token " + this.token
                    }
                }).then(function (response) {
                    if (response.data.suggestions) {
                        that.showList = true
                        that.results = response.data.suggestions
                    }else{
                        that.showList = false
                        that.results = []
                    }
                })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
        },
        mounted() {
            if (this.value) this.city = this.value
        }
    }
</script>
<style scoped>
    .form-group.error .form-group__inputs input{
        border: 1px solid #f24343;
    }
    .slide-fade-enter-active {
        transition: all .3s ease;
    }
    .slide-fade-leave-active {
        transition: all .3s cubic-bezier(1.0, 0.5, 0.8, 1.0);
    }
    .slide-fade-enter, .slide-fade-leave-to{
        transform: translateY(10px);
        opacity: 0;
    }
    .form-group__inputs{
        position: relative;
    }
    .dropdown-menu {
        position: absolute;
        display: flex;
        flex-direction: column;
        width: calc( 100% - 30px);
        max-height: 203px;
        overflow-y: scroll;
        z-index: 9;
        background: #fff;
        padding: 20px;
        box-shadow: 0 40px 60px 0 rgb(37 59 112 / 10%);
        border-bottom-left-radius: 8px;
        border-bottom-right-radius: 8px;
    }
    .dropdown-item {
        white-space: pre-wrap;
        cursor: pointer;
        font-size: 12px;
    }
    .dropdown-item:not(:last-child) {
        margin-bottom: 8px;
    }
</style>
