import { createRouter, createWebHistory } from "vue-router";
import ProductList from "./components/pages/ProductList.vue";
import ProductDetail from "./components/pages/ProductDetail.vue";
import AddProduct from "./components/pages/AddProduct.vue";
import Settings from "./components/pages/Settings.vue";
import Login from "./components/pages/Login.vue";

const routes = [
  { path: "/", name: "ProductList", component: ProductList },
  { path: "/login", name: "Login", component: Login },
  { path: "/product/:id", name: "ProductDetail", component: ProductDetail, props: true },
  { path: "/add-product", name: "AddProduct", component: AddProduct },
  { path: "/settings", name: "Settings", component: Settings },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
