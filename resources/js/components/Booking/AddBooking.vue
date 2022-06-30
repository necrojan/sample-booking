<template>
    <div class="my-2">
        <v-row

        >
            <v-col>
                <v-dialog
                    v-model="dialog"
                    fullscreen
                    hide-overlay
                    transition="dialog-bottom-transition"
                >
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            color="primary"
                            dark
                            v-bind="attrs"
                            v-on="on"
                        >
                            Add a booking
                        </v-btn>
                    </template>
                    <v-card>
                        <v-toolbar
                            dark
                            color="primary"
                        >
                            <v-btn
                                icon
                                dark
                                @click="dialog = false"
                            >
                                <v-icon>mdi-close</v-icon>
                            </v-btn>
                            <v-toolbar-title>Add a Booking</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-toolbar-items>
                                <v-btn
                                    dark
                                    text
                                    :disabled="!sameDate"
                                    @click="addBooking"
                                >
                                    Send
                                </v-btn>
                            </v-toolbar-items>
                        </v-toolbar>
                        <v-container>
                            <v-row>
                                <v-col cols="12">
                                    <v-alert v-if="timeIn != null && timeOut != null && !sameDate" type="warning">
                                        Booking date should be on the same date.
                                    </v-alert>
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
                                        v-model="timeIn"
                                        :date-picker-props="dateProps"
                                        :time-picker-props="timeProps"
                                    ></v-datetime-picker>
                                    {{ timeIn }}
                                </v-col>
                                <v-col
                                    cols="6"
                                >
                                    <h5>Check out Date:</h5>
                                    <v-datetime-picker
                                        v-model="timeOut"
                                        :date-picker-props="dateProps"
                                        :time-picker-props="timeProps"
                                    ></v-datetime-picker>
                                    {{ timeOut }}
                                </v-col>
                                <v-col
                                    class="d-flex"
                                    cols="12"
                                    sm="6"
                                >
                                    <v-select
                                        v-model="selectedRoom"
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
            </v-col>
        </v-row>
    </div>
</template>

<script>
import Swal from 'sweetalert2';
import moment from 'moment';
export default {
    name: "AddBookings",
    props: ['userId'],
    data () {
        return {
            timeProps: {
                min: '8:00',
                max: '17:00',
                format: '24hr'
            },
            dateProps: {
                min: moment().format('YYYY-MM-DD')
            },
            timeIn: null,
            timeOut: null,
            dialog: false,
            rooms: [],
            selectedRoom: null,
            alreadyBooked: false
        }
    },
    computed: {
        sameDate() {
            if (moment(this.timeIn).format('YYYY-MM-DD') != moment(this.timeOut).format('YYYY-MM-DD')) {
                return false;
            }
            return true;
        }
    },
    mounted() {
        this.getRooms();
    },

    methods: {
        getRooms() {
            axios.get('/admin/rooms').then(res => {
                this.rooms = res.data;
                console.log( moment().format('YYYY-MM-DD'))
                console.log('rooms', this.rooms)
            })
        },

        addBooking() {
            let payload = {
                room_id: this.selectedRoom,
                user_id: this.userId,
                check_in: moment(this.timeIn).format('YYYY-MM-DD HH:mm:ss'),
                check_out: moment(this.timeOut).format('YYYY-MM-DD HH:mm:ss'),
            }
            console.log('payload', payload);
            axios.post('/admin/bookings', payload).then(res => {

                Swal.fire(
                    'Great!',
                    'Booking has been added!',
                    'success'
                )

                this.dialog = false;
                this.$bus.$emit('BOOKING_ADDED');
                this.selectedRoom = null;
                this.timeIn = null;
                this.timeOut = null;
                this.alreadyBooked = false;
            }).catch(e => {
                console.log('error', e.response);
                if (e.response) {
                    this.dialog = true;
                    this.alreadyBooked = true;
                }
            });
        }
    }
}
</script>
