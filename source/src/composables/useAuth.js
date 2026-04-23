import { ref, computed } from 'vue'

// State dùng chung (singleton)
const isLoggedIn = ref(false)
const currentUser = ref(null)

export function useAuth() {
  // Đăng nhập (mock – chỉ cần email + password hợp lệ)
  const login = (email, password) => {
    return new Promise((resolve, reject) => {
      setTimeout(() => {
        if (email && password.length >= 6) {
          const namePart = email.split('@')[0]
          const displayName = namePart
            .split(/[._-]/)
            .map((w) => w.charAt(0).toUpperCase() + w.slice(1))
            .join(' ')
          currentUser.value = {
            email,
            name: displayName,
            avatar: null
          }
          isLoggedIn.value = true
          resolve({ success: true })
        } else {
          reject(new Error('Email hoặc mật khẩu không hợp lệ'))
        }
      }, 600)
    })
  }

  // Đăng ký (mock)
  const register = (fullName, email, password) => {
    return new Promise((resolve, reject) => {
      setTimeout(() => {
        if (fullName && email && password.length >= 6) {
          currentUser.value = { email, name: fullName, avatar: null }
          isLoggedIn.value = true
          resolve({ success: true })
        } else {
          reject(new Error('Thông tin không hợp lệ'))
        }
      }, 800)
    })
  }

  // Đăng xuất
  const logout = () => {
    isLoggedIn.value = false
    currentUser.value = null
  }

  const userInitial = computed(() => {
    if (!currentUser.value?.name) return ''
    return currentUser.value.name.charAt(0).toUpperCase()
  })

  return {
    isLoggedIn,
    currentUser,
    userInitial,
    login,
    register,
    logout
  }
}
