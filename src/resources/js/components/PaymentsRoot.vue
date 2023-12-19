<template>
    <v-row>
        <add-payment-form @refreshPaymentsEvent="getPayments"/>
    </v-row>
    <v-card>
        <v-card-title>
            Выплаты
            <v-spacer></v-spacer>
        </v-card-title>
        <v-data-table-server
            :headers="headers"

            :items="payments"
            :items-length="totalItems"

            v-model:items-per-page="itemsPerPage"
            :items-per-page-options="itemsPerPageVariants"
            :show-current-page="true"
            :show-next-page="true"
            :page="page"

            :loading="loading"

            @update:options="getPayments"
        >

            <template v-slot:item="{ item }">
                <tr :class="getColor(item.status)">
                    <td>
                        {{ item.user.name }}<br>
                        <span class="text-grey">{{ item.user.email }}</span>
                    </td>
                    <td>{{ item.creds }}</td>
                    <td :title="item.currency.title">{{ item.currency.symbol }}{{ item.sum }}</td>
                    <td>{{ item.currency.code }}</td>
                    <td>
                        <v-select
                            :items="statuses"
                            density="compact"
                            label="Статус"
                            v-model="item.status"
                            item-title="status"
                            single-line
                            required
                            @update:modelValue="toggleStatus($event, item.id)"
                        ></v-select>
                    </td>
                    <td>
                        <v-btn color="red" @click="deletePayment(item)">
                            Delete
                        </v-btn>
                    </td>
                </tr>
            </template>
        </v-data-table-server>
    </v-card>
</template>


<script>
import AddPaymentForm from "./AddPaymentForm.vue";

export default {
    name: 'PaymentsRoot',
    components: {AddPaymentForm},
    data: () => ({
        page: 1,
        itemsPerPage: 5,
        itemsPerPageVariants: [5, 10, 50, 100],
        loading: true,
        totalItems: 0,
        payments: [],
        statuses: ['open', 'paid'], //todo: get statuses
        headers: [
            {
                title: 'Логин',
                align: 'start',
                sortable: false,
            },
            {title: 'Реквизиты'},
            {title: 'Сумма', key: 'sum'},
            {title: 'Валюта'},
            {title: 'Статус заявки', key: 'status'},
        ],
    }),
    created () {
        this.getPayments({page: this.page});
        this.getStatuses();
    },
    methods: {
        getPayments({page}) {
            this.loading = true
            axios
                .get('/api/payments', {
                    params: {
                        perPage: this.itemsPerPage,
                        page: page,
                    }
                })
                .then((response) => {
                    this.payments = response.data.data
                    this.totalItems = response.data.meta.total
                    this.page = response.data.meta.current_page
                })
                .catch(error => console.log(error))
            this.loading = false
        },
        getStatuses() {
            axios
                .get('/api/statuses')
                .then((response) => {
                    this.statuses = response.data
                })
                .catch(error => console.log(error))
        },
        getColor (status) {
            switch (status) {
                case 'open':
                    return 'orange'
                case 'paid':
                    return 'green'
                default:
                    return 'grey'
            }
        },
        toggleStatus(e, iid) {
            console.log(e, iid);
            axios
                .post(`/api/payments/${iid}/toggleStatus`)
                .then((response) => {
                    //show OK message
                    console.log(response.data)
                })
                .catch(
                    //prevent select input toggling or toggle it back, show error message
                    error => console.log(error)
                )
        },
        deletePayment (item) {
            if (confirm('Are you sure you want to delete this payment?')) {
                axios
                    .delete(`/api/payments/${item.id}`)
                    .then((response) => {
                        //todo: show OK message
                        this.payments.splice(this.payments.indexOf(item), 1);
                    })
                    .catch(
                        //prevent select input toggling or toggle it back, show error message
                        error => console.log(error)
                    )
            }

        },
    }
}
</script>
