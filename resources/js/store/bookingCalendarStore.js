import { defineStore } from 'pinia'

export const dateModalStore = defineStore('dateModal', {
  state: () => {
    return {
      isOpen: false,
      dateInfo: null
    }
  },
  actions: {
    open () {
      this.isOpen = true
    },
    close () {
      this.isOpen = false
    },
    setDate (info) {
      this.dateInfo = info
    }
  }
})

export const blockDateConfirmationModalStore = defineStore('blockDateConfirmationModal', {
  state: () => {
    return {
      isOpen: false,
      dateInfo: null
    }
  },
  actions: {
    open () {
      this.isOpen = true
    },
    close () {
      this.isOpen = false
    },
    setDate (info) {
      this.dateInfo = info
    }
  }
})