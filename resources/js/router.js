import { createRouter, createWebHistory } from "vue-router";
import ProductList from "./components/pages/ProductList.vue";
import ProductDetail from "./components/pages/ProductDetail.vue";
import AddProduct from "./components/pages/AddProduct.vue";
import Settings from "./components/pages/Settings.vue";
import Login from "./components/pages/Login.vue";

const routes = [
  {
    path: "/",
    name: "ProductList",
    component: ProductList,
    meta: { requiresAuth: true },
  },
  {
    path: "/login",
    name: "Login",
    component: Login,
  },
  {
    path: "/product/:id",
    name: "ProductDetail",
    component: ProductDetail,
    props: true,
    meta: { requiresAuth: true },
  },
  {
    path: "/add-product",
    name: "AddProduct",
    component: AddProduct,
    meta: { requiresAuth: true },
  },
  {
    path: "/settings",
    name: "Settings",
    component: Settings,
    meta: { requiresAuth: true },
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// Verificar autenticação antes de cada rota
router.beforeEach((to, from, next) => {
  const isAuthenticated = !!localStorage.getItem("auth_token");

  if (to.meta.requiresAuth && !isAuthenticated) {
    next("/login");
  } else if (to.path === "/login" && isAuthenticated) {
    next("/");
  } else {
    next();
  }
});

export default router;
