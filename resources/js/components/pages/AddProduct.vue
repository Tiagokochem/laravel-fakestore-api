<template>
  <div class="add-product">
    <h2>Add Product</h2>
    <form @submit.prevent="addProduct">
      <input v-model="title" type="text" placeholder="Product Title" required />
      <input v-model="price" type="number" placeholder="Price" required />
      <input v-model="description" type="text" placeholder="Description" />
      <button type="submit">Add Product</button>
    </form>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "AddProduct",
  data() {
    return {
      title: "",
      price: "",
      description: "",
    };
  },
  methods: {
    addProduct() {
      axios.post("/api/products", {
        title: this.title,
        price: this.price,
        description: this.description,
      })
        .then(() => {
          this.$router.push("/");
        })
        .catch(() => {
          console.error("Error adding product");
        });
    },
  },
};
</script>

<style scoped>
.add-product {
  padding: 16px;
}
</style>
