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
    .comment__loading,
    .comment__submit {
        position: absolute;
        top: 50%;
        right: 8px;
        transform: translateY(-50%);
    }
    .comment__loading i,
    .comment__submit i {
        color: #48b0f7;
    }

    .comment__error {
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
    .comment__typing{
        font-size: 12px;
    }
</style>
<template>
    <div class="container">
        <div class="comments">

            <div v-if="comments" class="comments__wrap">
                <transition-group name="comments-transition" tag="div" class="comments__list">
                    <div v-for="item in renderComments" class="row justify-content-start" :key="item.id">
                        <CommentGuestItem
                            :usersOnline="usersOnline"
                            :ownerId="adsOwner"
                            :you="youTo"
                            :me="meTo"
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
                                <input type="text" name="comment" class="comment__input" id="comment" @keydown="actionUser" v-model="comment"
                                       placeholder="Введите текст">
                                <button v-if="!isDisabled" type="submit" class="btn comment__submit">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                                <span v-else class="btn comment__loading">
                                    <i class="fas fa-circle-notch fa-spin"></i>
                                </span>
                                <span v-if="error.status"
                                      class="help-block comment__error text-danger">{{ error.msg }}</span>
                            </div>
                            <div class="comment__row">
                                <span class="comment__typing" v-if="isUserTyping">{{isUserTyping.name}} печатает....</span>
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
                event: 'save',
                id: null,
                error: {
                    status: false,
                    msg: 'Не корректный ввод'
                },
                adsOwner: null,
                meTo: null,
                youTo: null,
                isUserTyping: false,
                typingTimer: false,
                usersOnline: []
            }
        },
        components: {
            CommentGuestItem
        },
        props: {

            me: {type: String},
            you: {type: String},
            ads: {type: String},
            subs: {type: String},
            commentId: {type: String},
            routeCreate: {type: String},
            routeUpdate: {type: String},
            token: {type: String},
            room: {type: String},
            owner: {type: String}
        },
        watch: {
            comment() {
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
                    const status = await this.sendRequest(`/profile/comments/${id}`, 'DELETE', {room: this.room})
                    if (status) this.removeById(id)
                } else {
                    return false
                }
            },
            removeById(id) {
                this.comments = this.comments.filter(item => item.id !== id)
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
                    if (item.id === comment.id) item = comment
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
                if (!this.isDisabled)
                    if (this.comment && !this.comment.trim() == '' && this.comment.length < 150) {
                        const data = {
                            id: this.id,
                            parent_id: this.commentId,
                            comment: this.comment,
                            article_id: this.ads,
                            from_user_id: this.meTo.user_id,
                            user_id: this.youTo.user_id,
                            room: this.room
                        }
                        let method
                        let route
                        if (this.event === 'save') {
                            method = 'POST'
                            route = this.routeCreate
                        } else {
                            method = 'PUT'
                            route = this.routeUpdate
                        }
                        this.isDisabled = true
                        try {
                            const response = await this.sendRequest(route, method, data)
                            if (this.event === 'save')
                                this.addItem(response.comment)
                            else
                                this.updateComment(response.comment)
                            this.comment = ''
                            this.event = 'save'
                        } catch (e) {
                            this.error.status = true
                        }
                        this.isDisabled = false


                    } else {
                        this.error.status = true
                    }
            },
            sendRequest(url, method, data) {
                let that = this
                return new Promise(function (resolve, reject) {
                    axios({
                        method,
                        url,
                        data,
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "Authorization": "Token " + that.token
                        }
                    }).then(response => {
                        resolve(response.data)
                    }).catch((error) => {
                        reject(error)
                    })
                })
            },
            actionUser(){
                this.channel
                .whisper('typing', {
                    name: this.meTo.name
                })
            }

        },
        computed: {
            renderComments() {
                return this.comments
            },
            channel(){
                return window.Echo.join(`room.20.1.2`)
            }
        },
        mounted() {
            if (this.me) {
                this.meTo = JSON.parse(this.me)
            }
            if (this.you) {
                this.youTo = JSON.parse(this.you)
            }
            if (this.subs) {
                this.comments = JSON.parse(this.subs)
            }
            if (this.owner) {
                this.adsOwner = this[this.owner].user_id
            }


            // Init chat
            this.channel
                .here(users => {
                    this.usersOnline = users
                })
                .joining(user => {
                    this.usersOnline.push(user)
                })
                .leaving( user => {
                    this.usersOnline.splice(this.usersOnline.indexOf(user))
                })
                .listen('.questions', ({data}) => {

                    if(data.event === 'delete') {
                        return this.comments = this.comments.filter(item => item.id !== data.id)
                    }
                    if(data.event === 'updated') {
                        return this.updateComment(data)
                    }




                    this.isUserTyping = false
                    this.comments.push({...data})
                })
                .listenForWhisper('typing', (e) => {
                    this.isUserTyping = e

                    if(this.typingTimer) clearTimeout(this.typingTimer)

                    this.typingTimer = setTimeout(() => {
                        this.isUserTyping = false
                    }, 2000)
                })

        }
    }
</script>
