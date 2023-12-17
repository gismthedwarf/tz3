import './bootstrap';

import {createApp} from 'vue';
import PaymentsRoot from './components/PaymentsRoot.vue';
import vuetify from './vuetify';

const app = createApp(PaymentsRoot)

app.use(vuetify).mount('#app');
