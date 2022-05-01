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
    .comment-item__noAuth .comment-item__changed {
        position: absolute;
        right: -25px;
    }
    .comment-item__noAuth .comment-item__changed i {
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
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .comment-item__online {
        margin-top: 8px;
        font-size: 10px;
        background: #82c831;
        padding: 0px 4px;
        border-radius: 4px;
        color: #ffffff;
    }
    .comment-item__offline {
        margin-top: 8px;
        font-size: 10px;
        background: #afafaf;
        padding: 0px 4px;
        border-radius: 4px;
        color: #ffffff;
    }

    .comment-item__comment {
        flex-grow: 1;
    }
    .comment-item .comment-item__link {
        width: 80%;
        border-radius: 10px;
        border: none;
        padding: 16px;
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

    .comment-item__auth h5,
    .comment-item__auth small,
    .comment-item__auth p {
        color: #ffffff;
    }
    .comment-item__auth .comment-item__link {
        /*transition: background-color 2s ease-out;*/
        background: #48b0f7;
        color: #ffffff;
    }
    .comment-item__actions {
        position: absolute;
        z-index: 2;
        right: 16px;
        top: 8px;
        color: #f5f6f7;
    }
    .comment-item__auth .comment-item__changed {
        position: absolute;
        left: -25px;
    }
    .comment-item__auth .comment-item__changed i {
        color: #d2d4d6;
    }
    .comment-item__icon:first-child {
        margin-right: 8px;
    }
    .comment-item__icon:hover {
        cursor: pointer;
        fill: #fecf37;
    }
    .comment-item__icon {
        font-size: 10px;
        width: 18px;
        height: 18px;
        fill: #fcddb3;
    }
    .comment-item__status{
        display: none;
    }
    .comment-item__status i{
        color:#04f2c6;
    }
    @media (max-width: 768px) {
        .comment-item__name{
            font-size: 14px;
            display: flex;
        }
        .comment-item .comment-item__link {
            width: 100%;
        }
    }
    @media (max-width: 560px) {
        .comment-item__ava {
            display: none;
        }
        .comment-item__status{
            display: block;
            margin-left: 8px;
        }
    }



</style>
<template>
    <div class="comment-item">

        <div class="comment-item__auth" v-if="Number(item.from_user_id) === Number(user)">
            <div class="comment-item__actions">
                <svg @click="edit(item.id)" class="comment-item__icon">
                    <use xlink:href="/images/icons.svg#fa-highlighter"></use>
                </svg>
                <svg @click="deleteComment(item.id)" class="comment-item__icon">
                    <use xlink:href="/images/icons.svg#icon-close"></use>
                </svg>

            </div>
            <div class="comment-item__link list-group-item list-group-item-action">
                <small>#{{item.id}}</small>
                <span class="comment-item__changed" v-if="compareDate(item.updated_at, item.created_at)">
                    <i class="fas fa-pencil-alt"></i>
                </span>
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">Вы</h5>
                </div>
                <p class="mb-1">{{item.comment}}</p>
            </div>
            <small class="comment-item__date">{{formatDate(item.updated_at)}}</small>
        </div>


        <div class="comment-item__noAuth" :class="{'blink': item.isUpdate}" v-else>
            <div class="comment-item__ava">
                <img class="comment-item__img" :src="`${users[item.from_user_id].image}?v=3`" alt="">
                <div class="comment-item__online" v-if="isUserOnline">в чате</div>
                <div class="comment-item__offline" v-else>не в чате</div>
            </div>
            <div class="comment-item__comment">
                <div class="comment-item__link list-group-item list-group-item-action">
                    <span class="comment-item__changed" v-if="compareDate(item.updated_at, item.created_at)">
                        <i class="fas fa-pencil-alt"></i>
                    </span>
                    <small>#{{item.id}}</small>

                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="comment-item__name mb-1">
                            {{users[item.from_user_id].name}} ({{item.from_user_id}})
                            <span class="comment-item__status">
                                <i class="fas" :class="[isUserOnline ? online : offline]"></i>
                            </span>
                        </h5>

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
        data: () => ({
            online: 'fa-eye',
            offline: 'fa-eye-slash'
        }),
        props: {
            users: {type: Object},
            user: {type: String},
            item: {type: Object},
            usersOnline: {type: Array}
        },
        methods: {
            edit(id) {
                this.$emit('onEdit', id);
            },
            deleteComment(id) {
                this.$emit('onDelete', id);
            },
            formatDate(dateStr) {
                return moment(dateStr).fromNow();
            },
            checkSender() {
                // console.log(this.users)
                // return this.users.filter(elem => {console.log(elem)})

            },
            compareDate(created, updated) {
                if (!moment(created).isSame(updated)) {
                    return true;
                }
            }
        },
        computed: {
            isUserOnline() {
                const onlineUsers = this.usersOnline.filter(user => this.item.from_user_id == user);
                return !!onlineUsers.length;
            }
        },
        mounted() {
            this.checkSender();
        }
    };
</script>
