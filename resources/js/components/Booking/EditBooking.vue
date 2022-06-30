<template>
    <v-row>
        <v-dialog
            v-if="booking"
            v-model="editDialog"
            fullscreen
            hide-overlay
            transition="dialog-bottom-transition"
        >
            <v-card>
                <v-toolbar
                    dark
                    color="primary"
                >
                    <v-btn
                        icon
                        dark
                        @click="closeEditDialog"
                    >
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                    <v-toolbar-title>Editing Booking #{{ booking.id }}</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-toolbar-items>
                        <v-btn
                            dark
                            text
                            @click="updateBooking"
                        >
                            Save
                        </v-btn>
                    </v-toolbar-items>
                </v-toolbar>
                <v-container>
                    <v-row>
                        <v-col cols="12">
                            <v-alert v-if="alreadyBooked" type="warning">
                                Check in date already been booked.
                            </v-alert>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col
                            cols="6"
                        >

                            <h5>Check in Date:</h5>
                            <v-datetime-picker
                                v-model="editedCheckIn"
                                :date-picker-props="dateProps"
                                :time-picker-props="timeProps"
                            ></v-datetime-picker>
                        </v-col>
                        <v-col
                            cols="6"
                        >
                            <h5>Check out Date:</h5>
                            <v-datetime-picker
                                v-model="editedCheckOut"
                                :date-picker-props="dateProps"
                                :time-picker-props="timeProps"
                            ></v-datetime-picker>
                        </v-col>
                        <v-col
                            class="d-flex"
                            cols="12"
                            sm="6"
                        >
                            <v-select
                                v-model="booking.room_id"
                                :items="rooms"
                                item-text="name"
                                item-value="id"
                                filled
                                label="Rooms"
                            ></v-select>
                        </v-col>
                    </v-row>
                </v-container>
            </v-card>
        </v-dialog>
    </v-row>
</template>

<script>
import moment from 'moment';
export default {
    name: "EditBooking",
    props: ['editDialog', 'userId', 'booking'],
    data () {
        return {
            alreadyBooked: false,
            notifications: false,
            sound: true,
            widgets: false,
            timeProps: {
                min: '8:00',
                max: '17:00',
                format: '24hr'
            },
            editedCheckIn: null,
            editedCheckOut: null,
            dateProps: {
                min: moment().format('YYYY-MM-DD')
            },
            rooms: []
        }
    },

    mounted() {
        this.getRooms();
    },

    computed: {
    },

    methods: {
        closeEditDialog() {
            this.$emit('closeEditDialog', false)
        },

        getRooms() {
            axios.get('/admin/rooms').then(res => {
                this.rooms = res.data;
            })
        },

        updateBooking() {
            let payload = {
                user_id: this.userId,
                room_id: this.booking.room_id,
                check_in: moment(this.editedCheckIn).format('YYYY-MM-DD HH:mm:ss'),
                check_out: moment(this.editedCheckOut).format('YYYY-MM-DD HH:mm:ss'),
            }
            axios.put('/admin/bookings/' + this.booking.id, payload).then(res => {
                this.editedCheckIn = null;
                this.editedCheckOut = null
                this.$emit('closeEditDialog', false);
                this.$bus.$emit('BOOKING_UPDATED');
                console.log('updated!', res.data)
            }).catch(e => {
                console.log('error', e.response);
                if (e.response) {
                    this.alreadyBooked = true;
                }
            })
        }
    }
}
</script>

<style scoped>

</style>
