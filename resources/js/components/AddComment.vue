<style scoped>
    .item__add {
        background: #eeeeeeb0;
        padding: 5px 10px;
        border-radius: 8px;
        margin-bottom: 16px;
    }
    .comments__list {
        margin-left: 24px;
        margin-top: 24px;
    }
    .comment-form {
        border-top: 2px solid #f5f6f7;
        display: flex;
    }
    .comment-form__btn {
        border-radius: 8px;
        background: #f5f6f7;
        height: max-content;
        display: block;
        margin-left: 8px;
    }
    .comment-form__edit {
        color: #48b0f7;
        border: none;
        background: none;
        padding: 14px 24px;
    }

    .comment__row {
        position: relative;
        width: 500px;
        margin-left: 86px;
    }

    .comment__input {
        background-color: #f5f6f7;
        border: none;
        padding: 16px;
        border-radius: 8px;
        width: 100%;
        color: #b19b9b;
    }

    .comment__submit {
        position: absolute;
        top: 50%;
        right: 8px;
        transform: translateY(-50%);
    }

    .comment__submit i {
        color: #48b0f7;
    }
    .comment__error{
        color: #e3342f !important;
        position: absolute;
        width: fit-content;
        left: 0;
        bottom: -21px;
        font-size: 12px;
    }
/*transition*/
    .comments-transition-enter-active,
    .comments-transition-leave-active,
    .comments-transition-move {
        transition: 500ms cubic-bezier(0.59, 0.12, 0.34, 0.95);
        transition-property: opacity, transform;
    }

    .comments-transition-enter {
        opacity: 0;
        transform: translateX(50px) scaleY(0.5);
    }

    .comments-transition-enter-to {
        opacity: 1;
        transform: translateX(0) scaleY(1);
    }

    .comments-transition-leave-active {
        transform: translateX(-50px);
    }
    .comments-transition-leave-to {
        opacity: 0;
        transform: translateX(50px) scaleY(0);
        transform-origin: center bottom;
    }
</style>
<template>
    <div class="container">
        <div class="comments">

            <div v-if="comments" class="comments__wrap">
                <transition-group name="comments-transition" tag="div" class="comments__list">
                <div v-for="item in renderComments" class="row justify-content-start" :key="item.id">
                    <CommentGuestItem
                        :currentUserId="currentUserId"
                        :sender="adsSender"
                        :recipient="adsRecipient"
                        :item="item"
                        @onEdit="editComment($event)"
                        @onDelete="deleteComment($event)"
                    >
                    </CommentGuestItem>
                </div>
                </transition-group>
            </div>

            <div ref="commentForm" class="row justify-content-start comment-form">
                <div class="card-body">
                    <form @submit.prevent="submit">
                        <div class="form-row align-items-center">
                            <div class="comment__row">
                                <input type="text" name="comment" class="comment__input" id="comment" v-model="comment"
                                       placeholder="Введите текст">
                                <button type="submit" class="btn comment__submit"><i class="fas fa-paper-plane"></i>
                                </button>
                                <span v-if="error.status" class="help-block comment__error text-danger">{{ error.msg }}</span>
                            </div>
                            <div class="comment-form__btn" v-if="event==='update'">
                                <button @click.prevent="exitEdit" class="comment-form__edit">
                                    <i class="comment-form__icon fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import CommentGuestItem from "./CommentGuestItem";

    export default {
        data() {
            return {
                isDisabled: false,
                answers: null,
                comment: null,
                comments: null,
                adsOwner: null,
                adsSender: null,
                adsRecipient: null,

                event: 'save',
                id: null,
                error: {
                    status: false,
                    msg: 'Не корректный ввод'
                }
            }
        },
        components: {
            CommentGuestItem
        },
        props: {
            currentUserId: {type: String},
            recipient: {type: String},
            sender: {type: String},
            ads: {type: String},
            subs: {type: String},
            commentId: {type: String},
            routeCreate: {type: String},
            routeUpdate: {type: String},
            token: {type: String}
        },
        computed: {
            renderComments() {
                return this.comments
            }
        },
        watch:{
            comment(){
                this.error.status = false
            }
        },
        methods: {
            exitEdit() {
                this.event = 'save'
                this.comment = ''
            },
            async deleteComment(id) {
                if (confirm('Удалить?')) {
                    const status = await this.sendRequest(`/profile/comments/${id}`, 'DELETE')
                    if(status) this.removeById(id)
                } else {
                    return false
                }
            },
            removeById(id){
                this.comments = this.comments.filter(item =>  item.id !== id)
            },
            editComment(id) {
                this.$refs.commentForm.scrollIntoView({block: "center", behavior: "smooth"});
                const commentText = this.comments.filter(item => item.id === id)
                this.comment = commentText[0].comment
                this.id = id
                this.event = 'update'
            },
            updateComment(comment) {
                this.comments = this.comments.map(item => {
                    if (item.id === comment.id)
                        item = comment
                    return item
                })
            },
            addItem(comment) {
                const tmp = {
                    comment: comment.comment,
                    created_at: new Date(),
                    updated_at: new Date(),
                    id: comment.id,
                    from_user_id: comment.from_user_id,
                    user_id: comment.user_id,
                }
                this.comments.push(tmp)
            },
            async submit() {
                if(!this.isDisabled)
                    if(this.comment && !this.comment.trim() == '' && this.comment.length < 150){
                      const data = {
                          id: this.id,
                          parent_id: this.commentId,
                          comment: this.comment,
                          article_id: this.ads,
                          from_user_id: this.adsSender.user_id,
                          user_id: this.adsRecipient.user_id
                      }
                      let method, route
                      if (this.event === 'save') {
                          method = 'POST'
                          route = this.routeCreate
                      } else {
                          method = 'PUT'
                          route = this.routeUpdate
                      }
                      this.isDisabled = true
                      const response = await this.sendRequest( route, method, data)
                      if(response){
                          if (this.event === 'save')
                              this.addItem(response.comment)
                          else
                              this.updateComment(response.comment)
                          this.comment = ''
                          this.event = 'save'
                      }
                        this.isDisabled = false
                  }else{
                      this.error.status = true
                  }
            },
            sendRequest(url, method, data) {
               return axios({
                    method,
                    url,
                    data,
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "Authorization": "Token " + this.token
                    }
                }).then( response => {
                    if (response.status) {
                        return response.data
                    }
                }).catch(function (error) {
                    return error.message
                });
            }
        },
        mounted() {
            if (this.recipient) {
                this.adsRecipient = JSON.parse(this.recipient)
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
