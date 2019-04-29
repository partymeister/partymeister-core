<template>
    <div>
        <div class="messages">
            <h3>Messages</h3>
            <div class="message" v-for="message in messages">
                <strong>{{message.username}}</strong>
                <p>{{message.text}}</p>
            </div>
        </div>
        <textarea name="" id="" cols="30" rows="10" placeholder="New Message"
                  v-on:keyup.enter="sendMessage"></textarea>
    </div>
</template>

<script>
    import fire from './../fire'

    export default {
        name: 'partymeister-core-chat',
        props: ['messageGroupName', 'messageGroupId', 'visitor', 'visitorApiToken'],
        data: () => {
            return {
                messages: []
            };
        },
        mounted: function () {
            let vm = this;
            const itemsRef = fire.database().ref('r2019/chats/' + this.messageGroupId + '_' + this.visitorApiToken);
            itemsRef.on('value', snapshot => {
                let data = snapshot.val();
                let messages = [];
                Object.keys(data).forEach(key => {
                    messages.push({
                        id: key,
                        name: data[key].name,
                        text: data[key].text
                    });
                });
                vm.messages = messages;
            });
        },
        methods: {
            sendMessage(e) {
                e.preventDefault();
                if (e.target.value) {
                    const message = {
                        name: this.messageGroupName,
                        text: e.target.value
                    };
                    //Push message to firebase reference
                    fire.database().ref('r2019/chats/' + this.messageGroupId + '_' + this.visitorApiToken).push(message);
                    e.target.value = ''
                }
            }
        }
    }
</script>


<style lang="scss">
</style>
