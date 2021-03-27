<style>
    .comment-item {
        display: flex;
        width: 100%;
        margin-bottom: 24px;
    }
    .comment-item__noAuth {
        justify-content: flex-start;
        width: 100%;
        display: flex;
    }
    .comment-item__noAuth .comment-item__link {
        background: #f5f6f7;
        color: #9b9b9b;
    }
    .comment-item__noAuth .comment-item__changed{
        position: absolute;
        right: -25px;
    }
    .comment-item__noAuth .comment-item__changed i{
        color: #d2d4d6;
    }



    .comment-item__img {
        width: 70px;
        border-radius: 100px;
        height: 70px;
        background: #f5f6f7;
    }
    .comment-item__ava {
        margin-right: 16px;
    }
    .comment-item__comment {
        flex-grow: 1;
    }
    .comment-item .comment-item__link {
        width: 80%;
        border-radius: 10px;
        border: none;
    }
    .comment-item__date {
        color: #9b9b9b;
    }

    .comment-item__auth {
        display: flex;
        align-items: flex-end;
        width: 100%;
        flex-direction: column;
        position: relative;
    }
    .comment-item__auth .comment-item__link {
        background: #48b0f7;
        color: #fff;
    }
    .comment-item__actions{
        position: absolute;
        z-index: 2;
        right: 16px;
        top: 8px;
        color: #f5f6f7;
    }
    .comment-item__auth .comment-item__changed{
        position: absolute;
        left: -25px;
    }
    .comment-item__auth .comment-item__changed i{
        color: #d2d4d6;
    }
    .comment-item__icon:first-child{
        margin-right: 8px;
    }
    .comment-item__icon:hover {
        cursor:pointer;
        color: #fecf37;
    }
    .comment-item__icon {
        font-size: 10px;
    }
</style>
<template>
    <div class="comment-item">


        <div class="comment-item__auth" v-if="checkSender(item.from_user_id)">
            <div class="comment-item__actions">
                <i @click="edit(item.id)" class="comment-item__icon fas fa-highlighter"></i>
                <i @click="deleteComment(item.id)" class="comment-item__icon fas fa-times"></i>
            </div>
            <div class="comment-item__link list-group-item list-group-item-action"> <small>#{{item.id}}</small>
                <span class="comment-item__changed" v-if="compareDate(item.updated_at, item.created_at)"><i class="fas fa-pencil-alt"></i></span>
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">Вы</h5>
                </div>
                <p class="mb-1">{{item.comment}}</p>
            </div>
            <small class="comment-item__date">{{formatDate(item.updated_at)}}</small>
        </div>


        <div class="comment-item__noAuth" v-else>
            <div class="comment-item__ava">
                <img class="comment-item__img" :src="recipient.ava" alt="">
            </div>
            <div class="comment-item__comment">
                <div class="comment-item__link list-group-item list-group-item-action">
                    <span class="comment-item__changed" v-if="compareDate(item.updated_at, item.created_at)"><i class="fas fa-pencil-alt"></i></span>
                    <small>#{{item.id}}</small>
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">{{item.name}} ({{item.from_user_id}})</h5>
                    </div>
                    <p class="mb-1">{{item.comment}}</p>
                </div>
                <small class="comment-item__date">{{formatDate(item.updated_at)}}</small>
            </div>
        </div>
    </div>

</template>
<script>
    export default {
        data: () => ({}),
        props: {
            recipient: {type: Object},
            currentUserId: {type: String},
            item: {type: Object},
            sender: {type: Object}
        },
        methods: {
            edit(id){
                this.$emit('onEdit', id)
            },
            deleteComment(id){
                this.$emit('onDelete', id)
            },
            formatDate(dateStr) {
                return moment(dateStr).fromNow()
            },
            checkSender(id) {
                if (id == this.sender.user_id){
                    return true
                }
                else return false
            },
            compareDate(created, updated){
                if(!moment(created).isSame(updated))
                    return true
            }
        }
    }
</script>
