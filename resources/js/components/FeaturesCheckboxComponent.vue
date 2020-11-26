<style scoped>
    .item__add {
        background: #eeeeeeb0;
        padding: 5px 10px;
        border-radius: 8px;
        margin-bottom: 16px;
    }

</style>
<template>
    <div class="container">


        <div v-for="(item, inx) in dynamicItems" :key="inx" class="row align-items-end item__add">
            <div class="form-group col-md-4">
                <label for="inputEmail4">Название</label>
                <input autocomplete="nope" v-model="item.key" type="text" class="form-control" id="inputEmail4" placeholder="Email">
            </div>
            <div class="form-group col-md-4">
                <label for="inputEmail4">Значение</label>
                <input autocomplete="nope" v-model="item.value" type="text" class="form-control" id="inputEmail4" placeholder="Email">
            </div>
            <div class="form-group col-md-2">
                <button class="btn btn-danger" type="button" @click="removeItem(inx)">удалить</button>
            </div>
        </div>


        <div class="row">
            <div class="form-group">
                <button type="button" class="btn btn-block btn-primary" @click.prevent="addRow()">Добавить</button>
            </div>
        </div>
    </div>

</template>

<script>
    export default {

        data() {
            return {
                items: [{
                    key: '',
                    value: ''
                }],
            }
        },
        props: ['data1'],
        methods: {
            addRow() {
                this.items.push({key: '', value: ""});
                // this.$emit('getList', this.items)
            },
            removeItem(inx) {
                this.items.splice(inx, 1);
                this.$emit('getList', this.items)
            },
            clear() {
                this.items = [{
                    key: '',
                    value: ''
                }]
            }
        },
        computed: {
            dynamicItems() {
                 return this.items
            }
        },
        mounted() {
            if(this.data1){
                this.items = JSON.parse(this.data1)
            }
        },
        created() {

        }
    }
</script>
