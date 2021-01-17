<template>
    <div>

        <div class="form-group">
            <label for="title">Заголовок</label>
            <input type="text" v-model="title" class="form-control" id="title" value="">
        </div>
        <div class="container">
            <div class="row">
                <component :data1="values" @getList="getList" ref="listBuilder" :is="stepForm"></component>
                <button class="btn btn-primary btn-block" @click.prevent="createFeature">Создать свойство</button>
            </div>

        </div>
    </div>
</template>
<script>
    import checkbox from './FeaturesCheckboxComponent'
    import radios from './FeaturesRadiosComponent'
    import list from './FeaturesListComponent'

    export default {
        data() {
            return {
                id: null,
                title: null,
                listItems: [],
                jsonData: null,
                types: ['Checkbox', 'Radio', 'List'],
                type: 'checkbox',
            }
        },
        props: ['url', 'values', 'feature', "method"],
        methods: {
            getList(items) {
                this.listItems = items
            },
            validate() {
                if (this.makeJson() && this.title && this.type) {
                    return true
                } else {
                    return false
                }
            },
            makeJson() {
                if (!this.listItems) return false
                let values = this.listItems.filter(function (el) {
                    return el.name != '';
                });
                this.jsonData = JSON.stringify(values);
                return true
            },
            createFeature() {
                this.listItems = this.$refs.listBuilder.items
                let that = this,
                    method = 'post'
                if(this.method.trim() === 'PUT')  method = 'put';
                if (this.validate()) {
                    axios({
                        method,
                        url: this.url,
                        data: {
                            title: this.title,
                            type: this.type,
                            value: this.jsonData,
                            require: 1,
                            id: this.id || false
                        }
                    }).then(function (response) {
                            alert(response.data)
                            if(that.method.trim() === 'POST') {
                                that.title = null
                                that.type = null
                                that.listItems = []
                                that.jsonData = null;
                                that.$refs.listBuilder.clear();
                            }
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                } else {
                    alert('Необходимо заполнить все поля')
                }
            }
        },
        mounted() {
            if(this.feature) {
                let tmpFeature  = JSON.parse(this.feature)
                this.title = tmpFeature.title
                this.type = tmpFeature.type
                this.id = tmpFeature.id
            }
        },
        computed: {
            stepForm() {
                return 'checkbox';
            },
        },
        components: {
            checkbox, radios, list
        },

    }
</script>
