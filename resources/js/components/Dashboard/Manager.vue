<template>
      <div>
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
                  <template v-slot:item.id="{ item }">
                      <div class="d-flex">
                          <v-icon @click="editBooking(item)" color="blue">mdi-lead-pencil</v-icon>
                          <v-icon @click="deleteBooking(item.id)" color="red">mdi-delete</v-icon>
                      </div>
                  </template>
              </v-data-table>
          </v-card>
          <add-booking :userId="userId"></add-booking>
          <edit-booking
              :userId="userId"
              :editDialog="editDialog"
              :booking="booking"
              v-on:closeEditDialog="closeEditDialog"
          ></edit-booking>
      </div>
</template>

<script>
import Swal from 'sweetalert2';

export default {
    name: "Manager",
    props: ['userId'],
    data () {
        return {
            bookings: [],
            search: '',
            editDialog: false,
            booking: null,
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
                {text: 'Action', align: 'left', sortable: false, value: 'id'},
            ]
        }
    },

    mounted() {
        this.getBookings();
        this.$bus.$on(['BOOKING_ADDED', 'BOOKING_UPDATED', 'BOOKING_DELETED'], () => {
            this.getBookings();
        });
        console.log('userId', this.userId);
    },

    methods: {
        getBookings() {
            axios.get('/admin/booking-list').then(response => {
                console.log(response.data);
                this.bookings = response.data;
            });
        },

        closeEditDialog(value) {
            this.editDialog = value;
        },

        editBooking(booking) {
            this.editDialog = true;
            this.booking = booking;
            console.log('edit', booking)
        },

        deleteBooking(id) {
            console.log('delete', id);
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/admin/bookings/' + id).then(response => {
                        Swal.fire(
                            'Deleted!',
                            'Your booking has been deleted.',
                            'success'
                        )
                        this.$bus.$emit('BOOKING_DELETED');
                        console.log('deleted', response.data);
                    });

                }
            })
        }
    }
}
</script>

<style scoped>

</style>
