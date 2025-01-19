import { defineStore } from 'pinia'
export const useUserStore = defineStore('user', {
  state: () => ({
    loggedIn: false,
    userToken: null
  }),
  getters: {
    isLoggedIn: state => {
      let loggedIn = window.localStorage.getItem('loggedIn')
      return loggedIn || state.loggedIn
    },
    getUserToken: state => {
      let userToken = window.localStorage.getItem('userToken')
      return userToken || state.userToken
    }
  },
  actions: {
    login(callback) {
      this.loggedIn = true
      window.localStorage.setItem('loggedIn', 'true')
      // ACTIVATE CALLBACK WITH THE LOGIN STATUS
      callback(true)
    },
    setUserToken(userToken){
      this.userToken = userToken;
      window.localStorage.setItem('userToken', userToken)
      return true; 
    }
  },
  
})
