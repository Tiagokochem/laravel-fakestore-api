<template>
  <div class="product-card">
    <img :src="product.image" alt="Product Image" class="product-image" />
    <div class="product-info">
      <h2 class="product-title">{{ product.title }}</h2>
      <p class="product-price">${{ product.price }}</p>
    </div>
  </div>
</template>

<script>
export default {
  name: "ProductCard",
  props: {
    product: {
      type: Object,
      required: true,
    },
  },
};
</script>

<style scoped>
.product-card {
  background-color: #fff;
  padding: 16px;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s, box-shadow 0.3s;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.product-card:hover {
  transform: scale(1.03);
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

.product-image {
  width: 100px;
  height: 100px;
  object-fit: cover;
  margin-bottom: 12px;
}

.product-info {
  text-align: center;
}

.product-title {
  font-size: 1rem;
  margin-bottom: 4px;
  color: #333;
}

.product-price {
  font-size: 1.2rem;
  font-weight: bold;
  color: #007bff;
}
</style>
