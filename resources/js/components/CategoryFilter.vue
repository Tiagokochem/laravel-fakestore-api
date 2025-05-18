<template>
  <div class="category-filter">
    <label for="category-select">Filter by Category:</label>
    <select id="category-select" v-model="selectedCategory" @change="onCategoryChange">
      <option value="">All Categories</option>
      <option v-for="category in categories" :key="category" :value="category">
        {{ category }}
      </option>
    </select>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "CategoryFilter",
  data() {
    return {
      categories: [],
      selectedCategory: "",
    };
  },
  methods: {
    async fetchCategories() {
      try {
        const response = await axios.get("/api/categories");
        this.categories = response.data;
      } catch (error) {
        console.error("Error fetching categories:", error);
      }
    },
    onCategoryChange() {
      this.$emit("category-selected", this.selectedCategory);
    },
  },
  mounted() {
    this.fetchCategories();
  },
};
</script>

<style scoped>
.category-filter {
  margin-bottom: 16px;
}

.category-filter label {
  margin-right: 8px;
  font-weight: bold;
}

.category-filter select {
  padding: 8px;
  border-radius: 4px;
  border: 1px solid #ccc;
}
</style>
