import { createRouter, createWebHistory } from "vue-router";
import ProductList from "./components/ProductList.vue";
import ProductDetail from "./components/ProductDetail.vue";

const routes = [
  { path: "/", component: ProductList },
  { path: "/product/:id", component: ProductDetail, props: true },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
