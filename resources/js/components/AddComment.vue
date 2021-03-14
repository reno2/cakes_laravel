<style scoped>
    .item__add {
        background: #eeeeeeb0;
        padding: 5px 10px;
        border-radius: 8px;
        margin-bottom: 16px;
    }
    .comments {
    }
    .comments__list {
        margin-left: 24px;
        margin-top: 24px;
    }
</style>
<template>
    <div class="container">
        <div class="comments">

            <div v-if="comments" class="comments__list">
                <div v-for="item in comments" class="row justify-content-start comment-form">
                    <CommentGuestItem
                        :currentUserId="currentUserId"
                        :sender="adsSender"
                        :item="item">
                    </CommentGuestItem>
                </div>
            </div>

            <div class="row justify-content-start comment-form">
                <div class="card-body">
                    <form @submit.prevent="submit">
                        <div class="form-group">
                            <label for="comment">Ответить</label>
                            <input type="text" name="comment" class="form-control" id="comment" v-model="comment"
                                   placeholder="Введите текст">
                        </div>
                        <button type="submit" class="btn btn-primary">написать</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import CommentGuestItem from "./CommentGuestItem";
    import CommentOwnerItem from "./CommentOwnerItem";
    export default {
        data() {
            return {
                answers: null,
                comment: null,
                comments: null,
                adsOwner: null,
                adsSender: null
            }
        },
        components:{
            CommentGuestItem
        },
        props: {
            currentUserId: {type: String},
            owner: {type: String},
            sender: {type: String},
            ads: {type: String},
            subs: {type: String},
            commentId: {type: String},
            route: {type: String},
            token: {type: String }
        },
        methods: {
            addItem(comment) {
                const tmp = {
                    comment: comment.comment,
                    created_at: new Date(),
                    id: comment.id,
                    from_user_id: comment.from_user_id,
                    user_id: comment.user_id,
                    //name: this.user_name
                }
                this.comments.push(tmp)
            },
            submit() {
                const that = this
                axios({
                    method: 'PUT',
                    url: that.route,
                    data: {
                        parent_id: that.commentId,
                        comment: that.comment,
                        article_id: that.ads,
                        from_user_id: that.user_id,
                        user_id: that.adsSender.user_id
                    },
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "Authorization": "Token " + that.token
                    }
                }).then(function (response) {
                    if (response.status) {
                        console.log(response.data.comment)
                        that.addItem(response.data.comment)
                    }
                }).catch(function (error) {
                        console.log(error);
                });
            }
        },
        mounted() {
            if (this.owner) {
                this.adsOwner = JSON.parse(this.owner)[0]
            }
            if (this.sender) {
                this.adsSender = JSON.parse(this.sender)
            }
            if (this.subs) {
                this.comments = JSON.parse(this.subs)
            }
        }
    }
</script>
