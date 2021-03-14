<style>
    .comment-item {
        display: flex;
        width: 100%;
        margin-bottom: 24px;
    }

    .comment-item__auth {
        display: flex;
        justify-content: flex-end;
        width: 100%;
    }
    .comment-item__noAuth{
        justify-content: flex-start;
        width: 100%;
    }
    .comment-item__noAuth .comment-item__link{
        background: #ebf8ff;
    }
    .comment-item__auth .comment-item__link{
        background: #d3efff;
    }
    .comment-item .comment-item__link{
        width: 80%;
        border-radius: 10px;
        border: none;
    }
</style>
<template>
    <div class="comment-item">
        <div class="comment-item__auth" v-if="checkSender(item.from_user_id)">
            <a href="#" class="comment-item__link list-group-item list-group-item-action"> <small>#{{item.id}}</small>
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">Вы</h5>
                    <small>{{formatDate(item.created_at)}}</small>
                </div>
                <p class="mb-1">{{item.comment}}</p>
            </a>
        </div>
        <div class="comment-item__noAuth" v-else>
            <a href="#" class="comment-item__link list-group-item list-group-item-action"> <small>#{{item.id}}</small>
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">{{item.name}} ({{item.from_user_id}})</h5>
                    <small>{{formatDate(item.created_at)}}</small>
                </div>
                <p class="mb-1">{{item.comment}}</p>
            </a>
        </div>
    </div>

</template>
<script>
    export default {
        data: () => ({}),
        props: {
            currentUserId: {type: String},
            item: {type: Object},
            sender: {type: Object}
        },
        methods: {

            formatDate(dateStr) {
                return moment(dateStr).fromNow()
            },
            checkSender(id) {
                if(id == this.sender.user_id) return true
                else return false
            }
        }


    }
</script>
