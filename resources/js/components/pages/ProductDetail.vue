<template>
  <div class="product-detail-container">
    <div class="product-card" v-if="product">
      <img :src="product.image" alt="Product Image" class="product-image" />
      <div class="product-info">
        <h1 class="product-title">{{ product.title }}</h1>
        <p class="product-price">${{ product.price }}</p>
        <p class="product-description">{{ product.description }}</p>
        <button class="back-button" @click="goBack">Back to Products</button>
      </div>
    </div>
    <div v-else class="loading">Loading product details...</div>
  </div>
</template>

<script>
import axios from "axios";
import { useRoute, useRouter } from "vue-router";
import { ref, onMounted } from "vue";

export default {
  name: "ProductDetail",
  setup() {
    const route = useRoute();
    const router = useRouter();
    const product = ref(null);

    onMounted(async () => {
      const productId = route.params.id;
      try {
        const response = await axios.get(`/api/products/${productId}`);
        product.value = response.data;
      } catch (error) {
        console.error("Error fetching product:", error);
      }
    });

    const goBack = () => {
      router.push("/");
    };

    return { product, goBack };
  },
};
</script>

<style scoped>
.product-detail-container {
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: #f0f2f5;
  min-height: 100vh;
  padding: 16px;
}

.product-card {
  background-color: #ffffff;
  padding: 24px;
  width: 100%;
  max-width: 600px;
  border-radius: 16px;
  box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
  display: flex;
  flex-direction: column;
  align-items: center;
  transition: transform 0.3s, box-shadow 0.3s;
}

.product-card:hover {
  transform: translateY(-5px);
  box-shadow: 0px 15px 30px rgba(0, 0, 0, 0.15);
}

.product-image {
  width: 250px;
  height: 250px;
  object-fit: cover;
  margin-bottom: 16px;
  border-radius: 8px;
  transition: transform 0.3s;
}

.product-card:hover .product-image {
  transform: scale(1.05);
}

.product-info {
  text-align: center;
}

.product-title {
  font-size: 1.5rem;
  font-weight: 600;
  color: #333;
  margin-bottom: 8px;
}

.product-price {
  font-size: 1.2rem;
  font-weight: 500;
  color: #007bff;
  margin-bottom: 12px;
}

.product-description {
  font-size: 1rem;
  color: #555;
  margin-bottom: 24px;
  line-height: 1.5;
}

.back-button {
  background-color: #007bff;
  color: #ffffff;
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.back-button:hover {
  background-color: #0056b3;
}
</style>
