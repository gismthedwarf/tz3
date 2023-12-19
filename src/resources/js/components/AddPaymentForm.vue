<template>
    <v-container :class="{'loading': loading}">
        <v-row v-show="!user">
            <v-col>
                <v-form @submit.prevent="authenticate">
                    <legend class="text-h4 mb-6">Войти</legend>
                    <v-container>

                        <v-row>
                            <v-col
                                cols="6"
                                md="6"
                            >
                                <v-text-field
                                    v-model="loginData.email"
                                    label="Email"
                                    hide-details
                                    required
                                    type="text"
                                ></v-text-field>
                                <div v-if="feedback.email">
                                    <p v-for="item in feedback.email">
                                        <span style="color:red" v-text="item"></span>
                                    </p>

                                </div>
                            </v-col>

                            <v-col
                                cols="6"
                                md="6"
                            >
                                <v-text-field
                                    label="Реквизиты"
                                    v-model="loginData.password"
                                    required
                                    hide-details
                                    type="password"
                                ></v-text-field>
                                <div v-if="feedback.password">
                                    <p v-for="item in feedback.password">
                                        <span style="color:red" v-text="item"></span>
                                    </p>

                                </div>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-btn
                                class="me-4"
                                type="submit"
                            >
                                Войти
                            </v-btn>
                            <div v-if="feedback.login">
                                <p v-for="item in feedback.login">
                                    <span style="color:red" v-text="item"></span>
                                </p>
                            </div>
                        </v-row>
                    </v-container>

                </v-form>
            </v-col>
        </v-row>


        <v-row v-show="user">
            <v-col>
                <v-form @submit.prevent="addPayment">
                    <v-container>
                        <legend class="text-h4 mb-6">Добавить выплату</legend>
                        <v-row>
                            <v-col
                                cols="12"
                                md="4"
                            >
                                <v-select
                                    v-model="selected_user"
                                    :items="users"
                                    item-title="name"
                                    item-value="id"
                                    label="Пользователь"
                                    single-line
                                    required
                                ></v-select>
                                <div v-if="feedback.user_id">
                                    <p v-for="item in feedback.user_id">
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
            loginData: {'email': 'admin@admin.ru', 'password': 'changeme'},
            user: false,
            loading: true,
            sum: '',
            creds: '',
            selected_currency: null,
            selected_user: null,
            currencies: [{'title': 'Выберите валюту', 'disabled': true, 'selected': true}],
            users: [{'title': 'Выберите пользователя', 'disabled': true, 'selected': true}],
            feedback: '',
            success: '',
        };
    },
    created() {
        //
    },
    methods: {
        authenticate() {
            let data = {
                email: this.loginData.email,
                password: this.loginData.password
            }

            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('/login', this.loginData).then(response => {
                    this.user = true;
                    this.getCurrencies();
                    this.getUsers();
                    this.loading = false;
                }).catch(error => {
                    this.feedback = error.response.data.errors
                });
            });
        },
        resetInput() {
            this.login = '';
            this.sum = '';
            this.creds = '';
            this.selected_currency = '';
            this.selected_user = '';
        },
        addPayment() {
            let data = {
                user_id: this.selected_user,
                sum: this.sum,
                creds: this.creds,
                currency_id: this.selected_currency
            }

            axios
                .post('/api/payments', data)
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
                .get('/api/currencies')
                .then((response) => {
                    this.currencies = response.data.data
                })
                .catch(error => console.log(error))
        },
        getUsers() {
            axios
                .get('/api/users')
                .then((response) => {
                    this.users = response.data.data
                })
                .catch(error => console.log(error))
        },
    },
}
</script>
