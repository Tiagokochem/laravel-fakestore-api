<template>
  <div class="app-container">
    <Sidebar />
    <div class="main-content">
      <Header />
      <router-view />
    </div>
  </div>
</template>

<script>
import Sidebar from "./components/layout/Sidebar.vue";
import Header from "./components/layout/Header.vue";

export default {
  name: "App",
  components: {
    Sidebar,
    Header,
  },
};
</script>


<style scoped>
.app-container {
  display: flex;
}

.main-content {
  margin-left: 220px; /* Alinha com a largura do sidebar */
  padding: 16px;
  flex-grow: 1;
  background-color: #ecf0f1;
  min-height: 100vh;
}
</style>
