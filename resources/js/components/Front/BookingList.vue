<template>
    <div>
        <h2>Booking List</h2>
        <v-btn
            class="mb-4"
            depressed
            color="primary"
            href="/login"
        >
            Login to Book
        </v-btn>
        <v-card>
            <v-card-title>
                <v-text-field
                    v-model="search"
                    append-icon="mdi-magnify"
                    label="Search"
                    single-line
                    hide-details
                ></v-text-field>
            </v-card-title>
            <v-data-table
                :headers="headers"
                :items="bookings"
                :search="search"
            >
                <template v-slot:item.user.name="{ item }">
                    <td>{{ $formatter.capitalize(item.user.name) }}</td>
                </template>
                <template v-slot:item.room.name="{ item }">
                    <td>{{ $formatter.capitalize(item.room.name) }}</td>
                </template>
            </v-data-table>
        </v-card>
    </div>
</template>

<script>
export default {
    name: "BookingList",
    data () {
        return {
            bookings: [],
            search: '',
            headers: [
                {
                    text: 'Room',
                    align: 'start',
                    value: 'room.name',
                },
                { text: 'Description', value: 'room.description' },
                { text: 'Booked By', value: 'user.name' },
                { text: 'Check in', value: 'check_in' },
                { text: 'Check out', value: 'check_out' },
            ]
        }
    },

    mounted() {
        this.getBookings();
    },

    methods: {
        getBookings() {
            axios.get('/booking-list').then(res => {
                console.log(res.data);
                this.bookings = res.data;
            });
        }
    }
}
</script>

<style scoped>

</style>
