<template>
  <div class="product-form">
    <h2>{{ isEditing ? 'Edit Product' : 'Add Product' }}</h2>
    <form @submit.prevent="saveProduct">
      <input v-model="product.title" placeholder="Title" required />
      <input v-model="product.price" type="number" placeholder="Price" required />
      <textarea v-model="product.description" placeholder="Description"></textarea>
      <input v-model="product.image" placeholder="Image URL" />

      <button type="submit">{{ isEditing ? 'Update' : 'Create' }}</button>
    </form>
  </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";

export default {
  name: "AddProduct",
  props: ["editingProduct"],
  data() {
    return {
      product: {
        title: "",
        price: "",
        description: "",
        image: "",
      },
      isEditing: false,
    };
  },
  watch: {
    editingProduct(newProduct) {
      if (newProduct) {
        this.product = { ...newProduct };
        this.isEditing = true;
      } else {
        this.resetForm();
      }
    },
  },
  methods: {
    async saveProduct() {
      try {
        const url = this.isEditing
          ? `/api/products/${this.product.id}`
          : "/api/products";
        const method = this.isEditing ? "put" : "post";

        await axios[method](url, this.product);

        Swal.fire({
          icon: "success",
          title: this.isEditing ? "Product Updated" : "Product Created",
          text: this.isEditing
            ? "The product was successfully updated."
            : "The product was successfully created.",
          timer: 2000,
        });

        this.$emit("product-saved");
        this.resetForm();
      } catch (error) {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "An error occurred while saving the product.",
        });
      }
    },
    resetForm() {
      this.product = { title: "", price: "", description: "", image: "" };
      this.isEditing = false;
    },
  },
};
</script>

<style scoped>
.product-form {
  background-color: #f9f9f9;
  padding: 16px;
  border-radius: 8px;
  margin-bottom: 16px;
}
</style>
