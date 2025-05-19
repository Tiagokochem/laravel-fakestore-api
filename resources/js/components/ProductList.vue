<template>
  <div class="product-list">
    <h1 class="page-title">Product List</h1>

    <button @click="syncProducts" class="sync-button">Sync Products</button>

    <CategoryFilter @category-selected="filterByCategory" />

    <div v-if="loading" class="loading">Loading products...</div>

    <div class="grid">
      <div v-for="product in paginatedProducts" :key="product.id" class="product-card">
        <img :src="product.image" alt="Product Image" class="product-image" />
        <h3>{{ product.title }}</h3>
        <p>${{ product.price }}</p>

        <div class="action-buttons">
          <button @click="editProduct(product)" class="edit-btn">
            Edit
          </button>

          <button @click="deleteProduct(product.id)" class="delete-btn">Delete</button>
        </div>
      </div>
    </div>



    <div class="pagination">
      <button @click="previousPage" :disabled="currentPage === 1" class="pagination-btn">
        Previous
      </button>
      <span>Page {{ currentPage }} of {{ totalPages }}</span>
      <button @click="nextPage" :disabled="currentPage === totalPages" class="pagination-btn">
        Next
      </button>
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
      products: [],
      filteredProducts: [],
      loading: true,
      currentPage: 1,
      itemsPerPage: 6,
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

    async fetchProducts(shouldSync = true) {
      this.loading = true;

      try {
        const response = await axios.get("/api/products");
        this.allProducts = response.data;
        this.filteredProducts = response.data;

        // Verifica a página atual e ajusta se necessário
        if (this.currentPage > this.totalPages) {
          this.currentPage = this.totalPages;
        }

      } catch (error) {
        console.error("Error fetching products:", error);

      } finally {
        this.loading = false;
      }
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

            await this.fetchProducts(false);

            // Ajusta a página atual
            if (this.currentPage > this.totalPages) {
              this.currentPage = this.totalPages;
            }

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

            // Atualiza a listagem, sem sincronizar
            await this.fetchProducts(false);

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
.product-list {
  padding: 16px;
  background-color: #f5f5f5;
  min-height: 100vh;
}

.sync-button {
  background-color: #28a745;
  color: #fff;
  padding: 8px 16px;
  border: none;
  cursor: pointer;
  border-radius: 4px;
  margin-bottom: 16px;
  transition: background-color 0.3s;
}

.sync-button:hover {
  background-color: #218838;
}

.grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
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

.product-card {
  background-color: #fff;
  padding: 16px;
  border-radius: 8px;
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
  display: flex;
  flex-direction: column;
  align-items: center;
  transition: transform 0.3s, box-shadow 0.3s;
  overflow: hidden;
}

.product-card:hover {
  transform: scale(1.02);
  box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.15);
}

.product-image {
  width: 150px;
  height: 150px;
  object-fit: cover;
  margin-bottom: 8px;
  border-radius: 8px;
}


.action-buttons {
  margin-top: 8px;
  display: flex;
  gap: 8px;
}

.edit-btn {
  background-color: #007bff;
  color: #fff;
  padding: 8px;
  border: none;
  cursor: pointer;
  border-radius: 4px;
  transition: background-color 0.3s;
}

.edit-btn:hover {
  background-color: #0056b3;
}

.delete-btn {
  background-color: #dc3545;
  color: #fff;
  padding: 8px;
  border: none;
  cursor: pointer;
  border-radius: 4px;
  transition: background-color 0.3s;
}

.delete-btn:hover {
  background-color: #c82333;
}
</style>
