<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Chats</div>

                    <div class="panel-body">
                        <chat-messages :messages="messages"></chat-messages>
                    </div>
                    <div class="panel-footer">
                        <chat-form
                            v-on:messagesent="addMessage"
                            :user="user"
                        ></chat-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['user','sender'],

        data() {
            return {
                messages: []
            }
        },

        created() {
            this.fetchMessages(this.sender);

            Echo.private(`chat.${this.user}`)
            .listen('MessageSent', (e) => {
                this.messages.push({
                    message: e.message.message,
                    created_at: e.message.created_at,
                    incoming: true,
                    sender: {
                        name: e.user.name
                    }
                });
            });
        },

        methods: {
            fetchMessages(sender) {
                axios.get(`/${sender}/messages`).then(response => {
                    this.messages = response.data.data;
                });
            },

            addMessage(message) {
                axios.post(`/${this.sender}/messages`, message).then(response => {
                    this.messages.push(response.data.data);
                });

            }
        }
    }
</script>
