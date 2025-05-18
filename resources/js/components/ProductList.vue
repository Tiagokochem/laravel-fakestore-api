<template>
  <div>
    <h1>Product List</h1>
    <div v-if="loading">Loading...</div>
    <div v-if="!loading && products.length">
      <ul>
        <li v-for="product in products" :key="product.id">
          {{ product.title }} - ${{ product.price }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      products: [],
      loading: true,
    };
  },
  async mounted() {
    try {
      const response = await axios.get('/api/products');
      this.products = response.data;
    } catch (error) {
      console.error("Error fetching products:", error);
    } finally {
      this.loading = false;
    }
  },
};
</script>
