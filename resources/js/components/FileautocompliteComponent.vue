<template>

    <div class="form-group row">
        <label for="address" class="col-md-4 col-form-label text-md-right">Город</label>
        <div class="col-md-6">
            <input required @blur="unblur" @keyup="fillAddress($event)" autocomplete="off" v-model="city" type="text" id="address"
                   name="address" :class="{'is-invalid' : message}" class="form-control">
            <span v-if="message" class="help-block text-danger">{{ message }}</span>
            <transition name="slide-fade">
                <div v-if="choosing" class="dropdown-menu">
                    <a @click="selectCity(item.value)" class="dropdown-item" v-for="(item, inx) in choosing" :key="inx">{{item.value}}</a>
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
    .slide-fade-enter-active {
        transition: all .3s ease;
    }
    .slide-fade-leave-active {
        transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
    }
    .slide-fade-enter, .slide-fade-leave-to{
        transform: translateY(10px);
        opacity: 0;
    }
    .dropdown-menu {
        position: absolute;
        display: block;
        width: calc( 100% - 30px);
        margin-top: -2px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        margin-left: 15px;
        max-height: 203px;
        overflow-y: scroll;
    }
    .dropdown-item {
        white-space: pre-wrap;
        cursor: pointer;
    }
</style>
