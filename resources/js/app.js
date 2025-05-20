import { createApp } from "vue";
import App from "./App.vue";
import router from "./router.js";
import "../css/app.css";
import axios from "axios";

// Configurar o interceptor ANTES de montar a aplicação
axios.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem("auth_token");
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

const app = createApp(App);
app.use(router);
app.mount("#app");
