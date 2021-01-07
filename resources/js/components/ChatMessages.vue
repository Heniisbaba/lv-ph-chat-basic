<template>
    <ul class="chat">
        <li class="left clearfix" v-for="message in messages" :key="message.id">
            <div class="chat-body clearfix" :class="{'bg-main' : message.incoming}">
                <div class="header">
                    <strong v-if="message.incoming" class="primary-font" >
                        {{ message.sender.name }}
                    </strong>
                    <strong v-else class="primary-font">
                        {{ message.me }}
                    </strong>
                </div>
                <p>
                    {{ message.message }}
                </p>
            </div>
        </li>
    </ul>
</template>

<style lang="css">
    .bg-main {
        background: #f9f9f6;
        border-radius: 20px;
        /* color: #fff; */
        padding: 2rem;
        text-align: end;
    }
</style>

<script>
  export default {
    props: ['messages']
  };
</script>
