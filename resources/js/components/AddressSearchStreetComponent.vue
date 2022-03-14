<template>

    <div class="form-group row">
        <label for="deal_address" class="form-group__placeholder">Место сделки</label>
        <div class="form-group__inputs">
            <input required @blur="unblur"
                   @keyup="fillAddress($event)"
                   autocomplete="off"
                   v-model="dealPlace"
                   type="text"
                   id="deal_address"
                   name="deal_address"
                   :class="{'is-invalid' : message}"
                   class="form-group__input">
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
            },
            userCity: {
                type: String,
                default: ''
            },
            target: {
                type: String,
                default: ''
            }
        },
        data() {
            return {
                token: '4411ab8ee14736f68ad24c1b445ce5e15fa395b4',
                dealPlace: '',
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
            selectCity(streetVal) {
                this.dealPlace = streetVal
                this.showList = false
            },
            fillAddress(event) {
                this.message = ''
                //console.log( this.$el)
                if (this.dealPlace.length > 3) {
                    let d = {
                        query: this.dealPlace,
                        // "from_bound": { "value": "street" },
                        // "to_bound": { "value": "street" },
                        "locations": [{ "city": this.userCity }],
                        "restrict_value": true

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
            if (this.value) this.dealPlace = this.value
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
