<template>
  <div class="sidebar">
    <div class="sidebar-header">
      <h2>Menu</h2>
    </div>
    <ul class="menu-list">
      <li>
        <router-link to="/">Home</router-link>
      </li>
      <li>
        <router-link to="/add-product">Add Product</router-link>
      </li>
      <li>
        <router-link to="/settings">Settings</router-link>
      </li>
      <li>
        <router-link to="/login">Login</router-link>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: "Sidebar",
};
</script>

<style scoped>
.sidebar {
  width: 220px;
  background-color: #2c3e50;
  color: #ecf0f1;
  height: 100vh;
  padding: 20px;
  position: fixed;
  top: 0;
  left: 0;
  overflow-y: auto;
}

.sidebar-header {
  font-size: 1.2rem;
  margin-bottom: 20px;
  font-weight: bold;
}

.menu-list {
  list-style: none;
  padding: 0;
}

.menu-list li {
  margin-bottom: 16px;
}

.menu-list li a {
  color: #ecf0f1;
  text-decoration: none;
  font-size: 1rem;
  transition: background-color 0.3s, padding-left 0.3s;
  padding: 8px 16px;
  display: block;
  border-radius: 8px;
}

.menu-list li a:hover {
  background-color: #34495e;
  padding-left: 24px;
}
</style>
