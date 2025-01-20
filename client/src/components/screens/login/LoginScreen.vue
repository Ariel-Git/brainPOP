<template>
  <main class="login_content">
    <logo />
    <LoginForm @submit="submit($event)"></LoginForm>
    <div v-if="error" class="error-container">
      <div class="error">{{ errorMessage }}</div>
    </div>
  </main>
</template>

<script>
// COMPONENTS
import Logo from '@/components/base/logo/Logo.vue'
import LoginForm from '@/components/compositions/forms/login/LoginForm.vue'
import { loginRequest } from '@/services/api';
import { useUserStore } from '@/stores/user';
export default {
  name: 'LoginScreen',
  emits: ['submit'],
  components: {
    Logo,
    LoginForm
  },
  data() {
    return {
      error: false,
      errorMessage:null
    }
  },
  methods: {
    async submit(credentials) {
      try {
        const response = await loginRequest(credentials);
        const userStore = useUserStore();
        userStore.setUserToken(`${response.data.token_type} ${response.data.access_token.plainTextToken}`); // for summary screen
        userStore.login(()=>{
          this.$router.push({ name: 'home' })
        })
      } catch (err) {
        switch(err.status){
          case 404: case 422:
            this.errorMessage = "Login Failed: Incorrect Credentials";
          break;
          default:
            this.errorMessage = "Login Failed: Please try again later";
        }
        this.error = true;
      }
    }
  }
}
</script>

<style lang="scss" scoped>
.login_content {
  display: flex;
  align-items: center;
  justify-content: flex-start;
  width: 100%;
  max-width: 782px;
  background: #fff;
  box-shadow: 0px 4px 4px 3px rgba(185, 185, 185, 0.2509803922);
  flex-direction: column;
  padding: 35px 0;
  height: -webkit-fill-available;
}
</style>
