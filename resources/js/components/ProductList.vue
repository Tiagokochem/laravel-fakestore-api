<template>
  <div class="product-list">
    <div class="header">
      <h1 class="page-title">Product List</h1>
      <button @click="syncProducts" class="sync-button">Sync Products</button>
    </div>

    <CategoryFilter @category-selected="filterByCategory" />

    <div v-if="loading" class="loading-spinner">
      <div class="spinner"></div>
    </div>

    <div v-else class="grid">
      <router-link v-for="product in paginatedProducts" :key="product.id"
        :to="{ name: 'ProductDetail', params: { id: product.id } }" class="product-card">
        <div class="product-image-container">
          <img :src="product.image" alt="Product Image" class="product-image" />
        </div>
        <div class="product-info">
          <h3 class="product-title">{{ product.title }}</h3>
          <p class="product-price">${{ typeof product.price === 'number' ? product.price.toFixed(2) : '0.00' }}</p>
        </div>
        <div class="action-buttons">
          <button @click.prevent="editProduct(product)" class="action-btn edit-btn">
            <i class="fas fa-edit"></i>
          </button>
          <button @click.prevent="deleteProduct(product.id)" class="action-btn delete-btn">
            <i class="fas fa-trash-alt"></i>
          </button>
        </div>
      </router-link>
    </div>

    <div class="pagination">
      <button @click="previousPage" :disabled="currentPage === 1" class="pagination-btn">Previous</button>
      <span>Page {{ currentPage }} of {{ totalPages }}</span>
      <button @click="nextPage" :disabled="currentPage === totalPages" class="pagination-btn">Next</button>
    </div>
  </div>
</template>


<script>
import axios from "axios";
import ProductCard from "./ProductCard.vue";
import CategoryFilter from "./CategoryFilter.vue";
import Swal from "sweetalert2";

export default {
  name: "ProductList",
  components: {
    ProductCard,
    CategoryFilter,
  },
  data() {
    return {
      allProducts: [],
      products: [],
      filteredProducts: [],
      currentFilter: null,
      loading: true,
      currentPage: 1,
      itemsPerPage: 8,
    };
  },
  computed: {
    totalPages() {
      if (this.filteredProducts.length === 0) return 1; // Evitar divisão por zero
      return Math.ceil(this.filteredProducts.length / this.itemsPerPage);
    },
    paginatedProducts() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const end = start + this.itemsPerPage;

      // Se `currentPage` estiver fora do range, volta para a última página
      if (start >= this.filteredProducts.length && this.currentPage > 1) {
        this.currentPage = this.totalPages;
        return this.filteredProducts.slice(
          (this.currentPage - 1) * this.itemsPerPage,
          this.currentPage * this.itemsPerPage
        );
      }

      return this.filteredProducts.slice(start, end);
    },

  },
  methods: {
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

    async fetchProducts(currentFilter = null, shouldSync = true) {
      this.loading = true;

      try {
        const response = await axios.get("/api/products");

        this.allProducts = response.data.map(product => ({
          ...product,
          price: Number(product.price) // Garante que seja um número
        }));

        if (currentFilter) {
          this.filterByCategory(currentFilter);
        } else {
          this.filteredProducts = this.allProducts;
        }

        if (this.currentPage > this.totalPages) {
          this.currentPage = this.totalPages;
        }

      } catch (error) {
        console.error("Error fetching products:", error);
      } finally {
        this.loading = false;
      }
    },

    async addProduct() {
      Swal.fire({
        title: "Add New Product",
        html: `
          <input type="text" id="title" class="swal2-input" placeholder="Title">
          <input type="number" id="price" class="swal2-input" placeholder="Price">
          <input type="text" id="image" class="swal2-input" placeholder="Image URL">
        `,
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: "Add",
        preConfirm: async () => {
          const title = Swal.getPopup().querySelector("#title").value;
          const price = Swal.getPopup().querySelector("#price").value;
          const image = Swal.getPopup().querySelector("#image").value;

          try {
            await axios.post("/api/products", { title, price, image });

            Swal.fire({
              icon: "success",
              title: "Added!",
              text: "Product added successfully.",
              timer: 2000,
            });

            // Reaplica o filtro atual
            await this.fetchProducts(this.currentFilter);

          } catch (error) {
            Swal.fire({
              icon: "error",
              title: "Error",
              text: "Error adding product.",
            });
          }
        },
      });
    },

    async syncProducts() {
      this.loading = true;

      try {
        await axios.post("/api/sync-products");

        Swal.fire({
          icon: "success",
          title: "Synchronization Complete",
          text: "Products have been successfully synchronized!",
          timer: 2000,
        });

        // Atualiza a listagem após a sincronização
        await this.fetchProducts(false);

      } catch (error) {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "Error synchronizing products.",
        });
      } finally {
        this.loading = false;
      }
    },

    async deleteProduct(id) {
      Swal.fire({
        title: "Are you sure?",
        text: "This action cannot be undone.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!",
      }).then(async (result) => {
        if (result.isConfirmed) {
          try {
            await axios.delete(`/api/products/${id}`);

            Swal.fire({
              icon: "success",
              title: "Deleted!",
              text: "Product deleted successfully.",
              timer: 2000,
            });

            // Reaplica o filtro atual
            await this.fetchProducts(this.currentFilter);

          } catch (error) {
            Swal.fire({
              icon: "error",
              title: "Error",
              text: "Error deleting product.",
            });
          }
        }
      });
    },

    async editProduct(product) {
      Swal.fire({
        title: "Edit Product",
        html: `
      <input type="text" id="title" class="swal2-input" value="${product.title}">
      <input type="number" id="price" class="swal2-input" value="${product.price}">
      <input type="text" id="image" class="swal2-input" value="${product.image}">
    `,
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: "Save",
        preConfirm: async () => {
          const title = Swal.getPopup().querySelector("#title").value;
          const price = Swal.getPopup().querySelector("#price").value;
          const image = Swal.getPopup().querySelector("#image").value;

          try {
            await axios.put(`/api/products/${product.id}`, { title, price, image });

            Swal.fire({
              icon: "success",
              title: "Updated!",
              text: "Product updated successfully.",
              timer: 2000,
            });

            // Reaplica o filtro atual
            await this.fetchProducts(this.currentFilter);

          } catch (error) {
            Swal.fire({
              icon: "error",
              title: "Error",
              text: "Error updating product.",
            });
          }
        },
      });
    },

    filterByCategory(category) {
      this.currentPage = 1;
      this.currentFilter = category;

      this.filteredProducts = this.allProducts.filter((product) => {
        const productCategory = product.category ? product.category : "Uncategorized";

        if (category) {
          return productCategory.toLowerCase() === category.toLowerCase();
        }

        return true;
      });
    },
  },
  mounted() {
    this.fetchProducts();
  },
};
</script>

<style scoped>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');

.product-list {
  padding: 32px;
  background-color: #f0f2f5;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  gap: 24px;
}

.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 24px;
}

.sync-button {
  background-color: #3498db;
  color: #fff;
  padding: 10px 20px;
  border: none;
  cursor: pointer;
  border-radius: 8px;
  transition: background-color 0.3s;
}

.sync-button:hover {
  background-color: #2980b9;
}

.grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: 24px;
  align-items: start;
}

.product-card {
  background-color: #fff;
  padding: 16px;
  border-radius: 12px;
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s, box-shadow 0.3s;
  display: flex;
  flex-direction: column;
  align-items: center;
  position: relative;
  overflow: hidden;
}

.product-card:hover {
  transform: translateY(-5px);
  box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.15);
}

.product-image-container {
  width: 100%;
  height: 160px;
  background-color: #ecf0f1;
  border-radius: 8px;
  overflow: hidden;
  display: flex;
  justify-content: center;
  align-items: center;
  margin-bottom: 12px;
}

.product-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.product-info {
  text-align: center;
  margin-bottom: 16px;
}

.product-title {
  font-size: 1rem;
  font-weight: 600;
  color: #34495e;
  margin-bottom: 6px;
  max-width: 180px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.product-price {
  font-size: 1.1rem;
  font-weight: bold;
  color: #2ecc71;
}

.action-buttons {
  display: flex;
  gap: 8px;
  position: absolute;
  top: 12px;
  right: 12px;
}

.action-btn {
  background-color: transparent;
  border: none;
  cursor: pointer;
  color: #34495e;
  font-size: 1.2rem;
  transition: color 0.3s;
}

.action-btn:hover {
  color: #3498db;
}

.edit-btn {
  color: #3498db;
}

.delete-btn {
  color: #e74c3c;
}

.loading-spinner {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 200px;
}

.spinner {
  width: 40px;
  height: 40px;
  border: 4px solid #3498db;
  border-top-color: transparent;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

.pagination {
  display: flex;
  justify-content: center;
  gap: 16px;
  margin-top: 24px;
}

.pagination-btn {
  padding: 10px 16px;
  background-color: #3498db;
  color: #fff;
  border: none;
  cursor: pointer;
  border-radius: 8px;
  transition: background-color 0.3s;
}

.pagination-btn:disabled {
  background-color: #bdc3c7;
  cursor: not-allowed;
}

.pagination-btn:hover:not(:disabled) {
  background-color: #2980b9;
}
</style>
