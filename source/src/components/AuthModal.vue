<script setup>
import { ref, reactive } from 'vue'
import { useAuth } from '../composables/useAuth.js'

const emit = defineEmits(['close'])
const { login, register } = useAuth()

const activeTab = ref('login') // 'login' | 'register'
const isLoading = ref(false)
const errorMsg = ref('')
const successMsg = ref('')

// Form đăng nhập
const loginForm = reactive({ email: '', password: '' })
const loginErrors = reactive({ email: '', password: '' })

// Form đăng ký
const registerForm = reactive({ fullName: '', email: '', password: '', confirm: '' })
const registerErrors = reactive({ fullName: '', email: '', password: '', confirm: '' })

const validateEmail = (email) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)

const switchTab = (tab) => {
  activeTab.value = tab
  errorMsg.value = ''
  successMsg.value = ''
}

// --- Đăng nhập ---
const handleLogin = async () => {
  loginErrors.email = ''
  loginErrors.password = ''
  errorMsg.value = ''

  let valid = true
  if (!validateEmail(loginForm.email)) { loginErrors.email = 'Email không hợp lệ'; valid = false }
  if (loginForm.password.length < 6) { loginErrors.password = 'Mật khẩu ít nhất 6 ký tự'; valid = false }
  if (!valid) return

  isLoading.value = true
  try {
    await login(loginForm.email, loginForm.password)
    successMsg.value = 'Đăng nhập thành công! Chào mừng bạn 🎉'
    setTimeout(() => emit('close'), 1200)
  } catch (e) {
    errorMsg.value = e.message
  } finally {
    isLoading.value = false
  }
}

// --- Đăng ký ---
const handleRegister = async () => {
  Object.keys(registerErrors).forEach(k => registerErrors[k] = '')
  errorMsg.value = ''

  let valid = true
  if (!registerForm.fullName.trim()) { registerErrors.fullName = 'Vui lòng nhập họ tên'; valid = false }
  if (!validateEmail(registerForm.email)) { registerErrors.email = 'Email không hợp lệ'; valid = false }
  if (registerForm.password.length < 6) { registerErrors.password = 'Mật khẩu ít nhất 6 ký tự'; valid = false }
  if (registerForm.password !== registerForm.confirm) { registerErrors.confirm = 'Mật khẩu xác nhận không khớp'; valid = false }
  if (!valid) return

  isLoading.value = true
  try {
    await register(registerForm.fullName, registerForm.email, registerForm.password)
    successMsg.value = 'Tạo tài khoản thành công! 🎉'
    setTimeout(() => emit('close'), 1200)
  } catch (e) {
    errorMsg.value = e.message
  } finally {
    isLoading.value = false
  }
}
</script>

<template>
  <!-- Overlay -->
  <div class="fixed inset-0 z-[200] flex items-center justify-center p-4" @click.self="$emit('close')">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="$emit('close')"></div>

    <!-- Modal Box -->
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden animate-zoomIn">
      <!-- Top decoration -->
      <div class="h-1.5 bg-gradient-to-r from-slate-900 via-gray-600 to-slate-900"></div>

      <div class="p-8">
        <!-- Logo & Title -->
        <div class="text-center mb-8">
          <span class="text-2xl font-black tracking-tighter text-slate-900">ChongDoo</span>
          <p class="text-gray-400 text-sm mt-1">Tài Khoản Thành Viên</p>
        </div>

        <!-- Tabs -->
        <div class="flex bg-[#f8f4f0] rounded-2xl p-1 mb-8">
          <button
            @click="switchTab('login')"
            :class="activeTab === 'login' ? 'bg-slate-900 text-white shadow-md' : 'text-gray-500 hover:text-slate-900'"
            class="flex-1 py-2.5 rounded-xl text-sm font-bold transition-all duration-300"
          >
            Đăng Nhập
          </button>
          <button
            @click="switchTab('register')"
            :class="activeTab === 'register' ? 'bg-slate-900 text-white shadow-md' : 'text-gray-500 hover:text-slate-900'"
            class="flex-1 py-2.5 rounded-xl text-sm font-bold transition-all duration-300"
          >
            Đăng Ký
          </button>
        </div>

        <!-- Success Message -->
        <div v-if="successMsg" class="mb-4 p-3 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm font-medium text-center">
          {{ successMsg }}
        </div>

        <!-- Error Message -->
        <div v-if="errorMsg" class="mb-4 p-3 bg-red-50 border border-red-200 rounded-xl text-red-600 text-sm font-medium text-center">
          {{ errorMsg }}
        </div>

        <!-- ===== ĐĂNG NHẬP ===== -->
        <form v-if="activeTab === 'login'" @submit.prevent="handleLogin" class="flex flex-col gap-4">
          <div>
            <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 block">Email</label>
            <input
              v-model="loginForm.email"
              type="email"
              placeholder="email@example.com"
              class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10 outline-none text-sm transition bg-[#f8f4f0] focus:bg-white"
            />
            <p v-if="loginErrors.email" class="text-xs text-red-500 mt-1">{{ loginErrors.email }}</p>
          </div>

          <div>
            <div class="flex justify-between items-center mb-2">
              <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Mật Khẩu</label>
              <button type="button" class="text-xs text-gray-400 hover:text-slate-900 transition underline">Quên mật khẩu?</button>
            </div>
            <input
              v-model="loginForm.password"
              type="password"
              placeholder="••••••••"
              class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10 outline-none text-sm transition bg-[#f8f4f0] focus:bg-white"
            />
            <p v-if="loginErrors.password" class="text-xs text-red-500 mt-1">{{ loginErrors.password }}</p>
          </div>

          <button
            type="submit"
            :disabled="isLoading"
            class="w-full bg-slate-900 text-white font-black py-3.5 rounded-full hover:bg-slate-700 transition duration-300 mt-2 uppercase tracking-wider text-sm disabled:opacity-60 disabled:cursor-not-allowed flex items-center justify-center gap-2"
          >
            <svg v-if="isLoading" class="animate-spin w-4 h-4" viewBox="0 0 24 24" fill="none">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
            </svg>
            {{ isLoading ? 'Đang xử lý...' : 'Đăng Nhập' }}
          </button>

          <p class="text-center text-xs text-gray-400 mt-2">
            Chưa có tài khoản?
            <button type="button" @click="switchTab('register')" class="text-slate-900 font-bold hover:underline">Đăng ký ngay</button>
          </p>
        </form>

        <!-- ===== ĐĂNG KÝ ===== -->
        <form v-if="activeTab === 'register'" @submit.prevent="handleRegister" class="flex flex-col gap-4">
          <div>
            <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 block">Họ & Tên</label>
            <input
              v-model="registerForm.fullName"
              type="text"
              placeholder="Nguyễn Văn A"
              class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10 outline-none text-sm transition bg-[#f8f4f0] focus:bg-white"
            />
            <p v-if="registerErrors.fullName" class="text-xs text-red-500 mt-1">{{ registerErrors.fullName }}</p>
          </div>

          <div>
            <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 block">Email</label>
            <input
              v-model="registerForm.email"
              type="email"
              placeholder="email@example.com"
              class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10 outline-none text-sm transition bg-[#f8f4f0] focus:bg-white"
            />
            <p v-if="registerErrors.email" class="text-xs text-red-500 mt-1">{{ registerErrors.email }}</p>
          </div>

          <div>
            <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 block">Mật Khẩu</label>
            <input
              v-model="registerForm.password"
              type="password"
              placeholder="Ít nhất 6 ký tự"
              class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10 outline-none text-sm transition bg-[#f8f4f0] focus:bg-white"
            />
            <p v-if="registerErrors.password" class="text-xs text-red-500 mt-1">{{ registerErrors.password }}</p>
          </div>

          <div>
            <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 block">Xác Nhận Mật Khẩu</label>
            <input
              v-model="registerForm.confirm"
              type="password"
              placeholder="Nhập lại mật khẩu"
              class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10 outline-none text-sm transition bg-[#f8f4f0] focus:bg-white"
            />
            <p v-if="registerErrors.confirm" class="text-xs text-red-500 mt-1">{{ registerErrors.confirm }}</p>
          </div>

          <button
            type="submit"
            :disabled="isLoading"
            class="w-full bg-slate-900 text-white font-black py-3.5 rounded-full hover:bg-slate-700 transition duration-300 mt-2 uppercase tracking-wider text-sm disabled:opacity-60 disabled:cursor-not-allowed flex items-center justify-center gap-2"
          >
            <svg v-if="isLoading" class="animate-spin w-4 h-4" viewBox="0 0 24 24" fill="none">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
            </svg>
            {{ isLoading ? 'Đang xử lý...' : 'Tạo Tài Khoản' }}
          </button>

          <p class="text-center text-xs text-gray-400 mt-2">
            Đã có tài khoản?
            <button type="button" @click="switchTab('login')" class="text-slate-900 font-bold hover:underline">Đăng nhập</button>
          </p>
        </form>
      </div>

      <!-- Close button -->
      <button @click="$emit('close')" class="absolute top-5 right-5 text-gray-400 hover:text-slate-900 transition bg-gray-100 hover:bg-gray-200 rounded-full p-2">
        <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>
  </div>
</template>

<style scoped>
@keyframes zoomIn {
  from { transform: scale(0.92); opacity: 0; }
  to { transform: scale(1); opacity: 1; }
}
.animate-zoomIn {
  animation: zoomIn 0.25s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
</style>
