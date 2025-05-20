<template>
  <div class="login-container">
    <div class="login-card">
      <h2>Login</h2>
      <form @submit.prevent="handleLogin">
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" v-model="email" required />
        </div>
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" v-model="password" required />
        </div>
        <button type="submit" class="login-button">Login</button>
      </form>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";
import { ref } from "vue";
import { useRouter } from "vue-router";

export default {
  name: "Login",
  setup() {
    const router = useRouter();
    const email = ref("");
    const password = ref("");

    const handleLogin = async () => {
      try {
        const response = await axios.post("/api/login", {
          email: email.value,
          password: password.value,
        });

        const token = response.data.token;
        localStorage.setItem("auth_token", token);

        axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;


        Swal.fire({
          icon: "success",
          title: "Login Successful",
          text: "You are being redirected...",
          timer: 1500,
          showConfirmButton: false,
        });

        setTimeout(() => {
          router.push("/");
        }, 1500);

      } catch (error) {
        Swal.fire({
          icon: "error",
          title: "Login Failed",
          text: error.response?.data?.message || "Login error",
        });
      }
    };

    return {
      email,
      password,
      handleLogin,
    };
  },
};
</script>



<style scoped>
.login-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-color: #f0f2f5;
}

.login-card {
  background-color: #ffffff;
  padding: 24px;
  width: 100%;
  max-width: 400px;
  border-radius: 12px;
  box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
}

.login-card h2 {
  margin-bottom: 16px;
  text-align: center;
}

.form-group {
  margin-bottom: 16px;
}

.form-group label {
  display: block;
  margin-bottom: 8px;
  font-weight: bold;
}

.form-group input {
  width: 100%;
  padding: 8px;
  border: 1px solid #ddd;
  border-radius: 6px;
}

.login-button {
  width: 100%;
  padding: 10px;
  background-color: #3498db;
  color: #fff;
  border: none;
  cursor: pointer;
  border-radius: 6px;
  transition: background-color 0.3s;
}

.login-button:hover {
  background-color: #2980b9;
}
</style>
