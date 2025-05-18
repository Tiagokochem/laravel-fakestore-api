<template>
  <div class="product-list">
    <h1 class="page-title">Product List</h1>

    <CategoryFilter @category-selected="filterByCategory" />

    <div v-if="loading" class="loading">Loading products...</div>

    <div v-else>
      <div class="grid">
        <ProductCard
          v-for="product in paginatedProducts"
          :key="product.id"
          :product="product"
        />
      </div>

      <div class="pagination">
        <button
          @click="previousPage"
          :disabled="currentPage === 1"
          class="pagination-btn"
        >
          Previous
        </button>

        <span>Page {{ currentPage }} of {{ totalPages }}</span>

        <button
          @click="nextPage"
          :disabled="currentPage === totalPages"
          class="pagination-btn"
        >
          Next
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import ProductCard from "./ProductCard.vue";
import CategoryFilter from "./CategoryFilter.vue";

export default {
  name: "ProductList",
  components: {
    ProductCard,
    CategoryFilter,
  },
  data() {
    return {
      products: [],
      filteredProducts: [],
      loading: true,
      currentPage: 1,
      itemsPerPage: 6,
    };
  },
  computed: {
    totalPages() {
      return Math.ceil(this.filteredProducts.length / this.itemsPerPage);
    },
    paginatedProducts() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.filteredProducts.slice(start, end);
    },
  },
  methods: {
    async fetchProducts() {
      try {
        const response = await axios.get("/api/products");
        this.products = response.data;
        this.filteredProducts = response.data;
      } catch (error) {
        console.error("Error fetching products:", error);
      } finally {
        this.loading = false;
      }
    },
    filterByCategory(category) {
      this.currentPage = 1;

      if (category) {
        this.filteredProducts = this.products.filter(
          (product) => product.category === category
        );
      } else {
        this.filteredProducts = this.products;
      }
    },
    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage++;
      }
    },
    previousPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
      }
    },
  },
  mounted() {
    this.fetchProducts();
  },
};
</script>

<style scoped>
.product-list {
  padding: 16px;
  background-color: #f5f5f5;
  min-height: 100vh;
}

.grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  gap: 16px;
}

.pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 16px;
}

.pagination-btn {
  padding: 8px 16px;
  margin: 0 8px;
  background-color: #007bff;
  color: #fff;
  border: none;
  cursor: pointer;
  border-radius: 4px;
}

.pagination-btn:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}
</style>
