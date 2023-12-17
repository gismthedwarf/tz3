<template>
    <v-container>
        <v-row>
            <v-col>
                <v-form @submit.prevent="addPayment">
                    <v-container>
                        <legend class="text-h4 mb-6">Добавить выплату</legend>
                        <v-row>
                            <v-col
                                cols="12"
                                md="4"
                            >
                                <v-text-field
                                    v-model="login"
                                    label="Логин"
                                    required
                                    hide-details
                                ></v-text-field>
                                <div v-if="feedback.login">
                                    <p v-for="item in feedback.login">
                                        <span style="color:red" v-text="item"></span>
                                    </p>

                                </div>
                            </v-col>

                            <v-col
                                cols="12"
                                md="4"
                            >
                                <v-text-field
                                    v-model="sum"
                                    label="Сумма"
                                    hide-details
                                    required
                                    type="number"
                                ></v-text-field>
                                <div v-if="feedback.sum">
                                    <p v-for="item in feedback.sum">
                                        <span style="color:red" v-text="item"></span>
                                    </p>

                                </div>
                            </v-col>

                            <v-col
                                cols="12"
                                md="4"
                            >
                                <v-textarea
                                    label="Реквизиты"
                                    v-model="creds"
                                    required
                                    hide-details
                                ></v-textarea>
                                <div v-if="feedback.creds">
                                    <p v-for="item in feedback.creds">
                                        <span style="color:red" v-text="item"></span>
                                    </p>

                                </div>
                            </v-col>

                            <v-select
                                v-model="selected_currency"
                                :items="currencies"
                                item-title="title"
                                item-value="id"
                                label="Валюта"
                                single-line
                                required
                            ></v-select>
                            <div v-if="feedback.currency_id">
                                <p v-for="item in feedback.currency_id">
                                    <span style="color:red" v-text="item"></span>
                                </p>

                            </div>
                        </v-row>
                        <v-row>
                            <v-btn
                                class="me-4"
                                type="submit"
                            >
                                Добавить
                            </v-btn>
                            <div v-if="feedback.general">
                                <p v-for="item in feedback.general">
                                    <span style="color:red" v-text="item"></span>
                                </p>
                            </div>
                            <div v-if="success">
                                <span style="color:green" v-text="success"></span>
                            </div>
                        </v-row>

                    </v-container>
                </v-form>
            </v-col>
        </v-row>
    </v-container>
</template>


<script>

export default {
    name: 'AddPaymentForm',
    data() {
        return {
            login: '',
            sum: '',
            creds: '',
            selected_currency: null,
            currencies: [{'title': 'Выберите валюту', 'disabled': true, 'selected': true}],
            feedback: '',
            success: '',
        };
    },
    created() {
        this.getCurrencies();
    },
    methods: {
        resetInput() {
            this.login = '';
            this.sum = '';
            this.creds = '';
            this.selected_currency = '';
        },
        addPayment() {
            let data = {
                login: this.login,
                sum: this.sum,
                creds: this.creds,
                currency_id: this.selected_currency
            }

            axios
                .post('/payments', data)
                .then((response) => {
                    this.success = 'Successfully added',
                    this.feedback = '',
                    this.resetInput(),
                    console.log('r', response)
                })
                .catch(error => {
                    this.feedback = error.response.data.errors,
                        console.log('e', error.response.data.errors)
                })
        },
        getCurrencies() {
            axios
                .get('/currencies')
                .then((response) => {
                    this.currencies = response.data.data
                })
                .catch(error => console.log(error))
        },
    },
}
</script>
