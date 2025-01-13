import { defineStore } from 'pinia'
export const useUserStore = defineStore('user', {
  state: () => ({
    loggedIn: false
  }),
  getters: {
    isLoggedIn: state => {
      let loggedIn = window.localStorage.getItem('loggedIn')
      return loggedIn || state.loggedIn
    }
  },
  actions: {
    login(callback) {
      this.loggedIn = true
      window.localStorage.setItem('loggedIn', 'true')
      // ACTIVATE CALLBACK WITH THE LOGIN STATUS
      callback(true)
    }
  }
})
