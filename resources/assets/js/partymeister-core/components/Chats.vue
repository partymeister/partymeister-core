<template>
    <div>
        <div class="message-group-search">
            <select v-model="selectedMessageGroup">
                <option :value="false">Please choose your message group</option>
                <option v-for="group in messageGroups" :value="group.uuid">{{group.name}}</option>
            </select>
        </div>
        <div class="visitor-search">
            <select v-model="selectedVisitor">
                <option :value="false">Please choose a visitor</option>
                <option v-for="visitor in visitors" :value="visitor.uuid">{{visitor.name}}</option>
            </select>
        </div>
        <div class="chats">
            <div v-if="chats.length === 0">
                No chats for this message group
            </div>
            <div v-for="chat in chats">
                Chat between {{selectedMessageGroup}} and {{chat.uuid}} exists
            </div>
        </div>
        <div v-if="selectedMessageGroup !== false && selectedVisitor !== false" class="messages">
            <div v-for="message in messages">
                {{message.name}}: {{message.text}}
            </div>
            <textarea name="" id="" cols="30" rows="10" placeholder="New Message"
                      v-on:keyup.enter="sendMessage"></textarea>
        </div>
    </div>
</template>

<script>
    import fire from './../fire'

    export default {
        name: 'partymeister-core-chats',
        props: ['messageGroupsJson', 'visitorsJson'],
        data: () => {
            return {
                messageGroups: [],
                visitors: [],
                selectedMessageGroup: false,
                selectedVisitor: false,
                chats: [],
                activeChatId: null,
                messages: [],
            };
        },
        watch: {
            selectedVisitor: function (newValue, oldValue) {
                if (this.selectedMessageGroup !== false && this.selectedVisitor !== false) {
                    this.loadMessagesForVisitor();
                } else if (this.selectedMessageGroup !== false && this.selectedVisitor === false) {
                    this.chats = this.loadChatsForMessageGroup();
                }
            },
            selectedMessageGroup: function (newValue, oldValue) {
                if (this.selectedMessageGroup !== false && this.selectedVisitor !== false) {
                    this.loadMessagesForVisitor();
                } else if (this.selectedMessageGroup !== false && this.selectedVisitor === false) {
                    this.chats = this.loadChatsForMessageGroup();
                }
            }
        },
        created: function () {
            // console.log(this.messageGroupsJson);
            this.messageGroups = JSON.parse(this.messageGroupsJson);
            this.visitors = this.visitorsJson;
            // this.visitors = JSON.parse(this.visitorsJson);
            // console.log(this.visitorsJson);
        },
        methods: {
            checkIfChatExists() {
                console.log('Load chat for visitor');

                let chats = this.loadChatsForMessageGroup();
                for (let chat of chats) {
                    if (chat.visitorUuid === this.selectedVisitor) {
                        return chat.chatId;
                    }
                }
                return this.createChat();
            },
            createChat() {
                let activeChatId = this.selectedMessageGroup + '-' + this.selectedVisitor;
                const chat = {
                    name: "New chat",
                    visitorUuid: this.selectedVisitor,
                    chatId: activeChatId,
                };
                //Push message to firebase reference
                fire.database().ref('r2019/chats/' + this.selectedMessageGroup).push(chat);
                return activeChatId;

            },
            loadMessagesForVisitor() {
                console.log("Load messages");
                let vm = this;
                this.activeChatId = this.checkIfChatExists();
                if (this.activeChatId !== null) {
                    let itemsRef = fire.database().ref('r2019/messages/' + this.activeChatId);
                    itemsRef.on('value', snapshot => {
                        let messages = [];
                        let data = snapshot.val();
                        if (data !== null) {
                            Object.keys(data).forEach(key => {
                                messages.push({
                                    id: key,
                                    name: data[key].name,
                                    text: data[key].text,
                                    date: data[key].date
                                });
                            });
                        }
                        vm.messages = messages;
                    });

                }
                this.messages = [];
            },
            loadChatsForMessageGroup() {

                let vm = this;
                console.log('Load chats for message group');

                let chats = [];
                let itemsRef = fire.database().ref('r2019/chats/' + this.selectedMessageGroup);
                itemsRef.on('value', snapshot => {
                    let data = snapshot.val();
                    if (data !== null) {
                        Object.keys(data).forEach(key => {
                            chats.push({
                                id: key,
                                visitorUuid: data[key].visitorUuid,
                                chatId: data[key].chatId,
                            });
                        });
                    }
                });
                return chats;
            },
            sendMessage(e) {
                e.preventDefault();
                if (e.target.value) {
                    const message = {
                        name: "TEST",
                        text: e.target.value,
                        date: new Date()
                    };
                    //Push message to firebase reference
                    fire.database().ref('r2019/messages/' + this.activeChatId).push(message);
                    e.target.value = ''
                }
            },
            initiateChat() {

            },
        }
    }
</script>


<style lang="scss">
</style>
