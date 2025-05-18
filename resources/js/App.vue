<template>
  <router-view />
</template>

<script>
import { createApp } from "vue";
import router from "./router.js";

export default {
  name: "App",
};

const app = createApp({});
app.use(router);
app.mount("#app");
</script>
