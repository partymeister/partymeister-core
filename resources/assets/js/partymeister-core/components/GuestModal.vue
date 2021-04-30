<template>
    <div class="modal fade" id="guest-modal" tabindex="-1" role="dialog" aria-labelledby="">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        {{$t('partymeister-core.backend.guests.mark_as_arrived')}}
                    </h4>
                    <div class="float-right">
                        <button class="btn btn-default outline-secondary" data-dismiss="modal" aria-label="Close">
                            Cancel
                        </button>
                        <button class="btn btn-success" @click="confirm()" data-dismiss="modal">Confirm</button>
                    </div>
                </div>
                <div class="modal-body">
                    <div v-if="comment != ''" v-html="'<p>'+nl2br(comment)+'</p>'"></div>
                    <div class="alert alert-info">
                        <p v-if="has_badge" style="margin-bottom: 0; padding: 1rem 0;font-size: 20px;"
                           v-html="$t('partymeister-core.backend.guests.badge_info_vue', {name: name})">
                        </p>
                        <p v-if="ticket_code != ''" style="margin-bottom: 0; padding: 1rem 0;font-size: 20px;"
                           v-html="$t('partymeister-core.backend.guests.ticket_code_info_vue', {ticket_code: ticket_code})">
                        </p>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<style lang="scss">
    .motor-cms-components button {
        width: 200px;
    }
</style>

<script>

    export default {
        name: 'partymeister-core-guest-modal',
        props: ['apiToken'],
        data: () => {
            return {
                id: '',
                element: '',
                ticket_code: '',
                comment: '',
                name: '',
                has_badge: false
            };
        },
        created: function () {
            this.$eventHub.$on('partymeister-core:update-guest-modal', (payload) => {


                axios.get(route('api.guests.show', [payload.record]) + '?api_token=' + this.apiToken).then((response) => {

                    if (this.update(payload.element, response.data.data)) {
                        $('#guest-modal').modal('show');
                    } else {
                        this.confirm();
                    }
                });
            });
        },
        methods: {
            nl2br: function (string) {
                return (string + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1<br>$2');
            },
            update: function (element, data) {
                this.element = element;
                this.id = data.id;
                this.ticket_code = data.ticket_code;
                this.name = data.name;
                this.has_badge = data.has_badge;
                this.comment = data.comment;

                if (data.has_arrived) {
                    return false
                }

                if (this.has_badge || this.comment != '' || this.ticket_code != '') {
                    return true;
                }

                return false;
            },
            confirm: function () {
                axios.patch(route('api.guests.update', [this.id]) + '?api_token=' + this.apiToken, {
                    arrived_at: new Date().toISOString().slice(0, 19).replace('T', ' '),
                    has_arrived: $(this.element).data('has-arrived')
                }).then((response) => {
                    toastr.options = {progressBar: true};
                    toastr.success(this.$t('partymeister-core.backend.guests.arrival_status_updated'), this.$t('motor-backend.backend.global.flash.success'));

                    switchCssClass(this.element, response.data.data.has_arrived, $(this.element).data('class'), $(this.element).data('class-alternate'));
                    $(this.element).data('has-arrived', response.data.data.has_arrived ? 0 : 1);
                });
            }
        }
    }
</script>


<style lang="scss">
</style>
