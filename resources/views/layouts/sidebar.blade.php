<a href="{{ route('admin.booking.index') }}" style="text-decoration: none; color: black;">
    <v-list-item>
        <v-list-item-action class="m-1">
            <v-icon>mdi-calendar</v-icon>
        </v-list-item-action>
        <v-list-item-content>
            <v-list-item-title>Dashboard</v-list-item-title>
        </v-list-item-content>
    </v-list-item>
</a>



<v-list-item link @click="logoutMethod('{{ route('logout') }}')">
    <v-list-item-action class="m-1">
        <v-icon>mdi-logout</v-icon>
    </v-list-item-action>
    <v-list-item-content>
        <v-list-item-title>Logout</v-list-item-title>
    </v-list-item-content>
</v-list-item>
