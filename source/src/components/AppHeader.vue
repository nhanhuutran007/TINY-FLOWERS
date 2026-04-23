<script setup>
import { ref } from 'vue'
import { useCart } from '../composables/useCart.js'
import { useAuth } from '../composables/useAuth.js'
import SearchModal from './SearchModal.vue'
import AuthModal from './AuthModal.vue'

// ── Modal open states ──────────────────────────────────────
const isSearchOpen = ref(false)
const isAuthOpen = ref(false)
const isUserDropdownOpen = ref(false)

// ── Cart & Auth composables ────────────────────────────────
const { cartCount, openCart } = useCart()
const { isLoggedIn, currentUser, userInitial, logout } = useAuth()

const handleAccountClick = () => {
  if (isLoggedIn.value) {
    isUserDropdownOpen.value = !isUserDropdownOpen.value
  } else {
    isAuthOpen.value = true
  }
}

const handleLogout = () => {
  logout()
  isUserDropdownOpen.value = false
}

// Expose for App.vue to use
defineExpose({ isSearchOpen, isAuthOpen })

// 1. SALE (Cập nhật đồ Gen Z)
const menuSale = ref([
  {
    category: 'FLASH SALE XẢ KHO',
    items: ['Áo Boxy Sale Dưới 149K', 'Quần Parachute Dưới 199K', 'Phụ Kiện Đồng Giá 49K']
  },
  {
    category: 'DEAL MÙA LỄ HỘI',
    items: ['Mua 1 Tặng 1 (Items Chọn Lọc)', 'Giảm 30% Toàn Bộ Giỏ Hàng', 'Freeship Mọi Đơn']
  }
])

// 2. TRANG PHỤC (Cập nhật phong cách Gen Z)
const menuTrangPhuc = ref([
  {
    category: 'NEW ARRIVALS',
    items: ['Fall/Winter 2026 Collection', 'The "Y2K Revival" Drop', 'Minimal Streetwear']
  },
  {
    category: 'THEO PHONG CÁCH',
    items: ['Acubi / Y2K Style', 'Korean Streetwear', 'Oversized / Comfy Core', 'Gorpcore (Đồ Chức Năng)']
  }
])

// 3. ÁO (Mở rộng & cập nhật form Gen Z)
const menuAo = ref([
  {
    category: 'ÁO THUN (T-SHIRT)',
    items: ['Áo Thun Form Boxy', 'Áo Thun Oversize / Drop Shoulder', 'Baby Tee Nam (Fitted T-shirt)', 'Áo Thun Rách / Wash Bụi', 'Áo Raglan Tay Lỡ']
  },
  {
    category: 'ÁO SƠ MI / POLO',
    items: ['Sơ Mi Cuban Collar (Cổ V)', 'Sơ Mi Form Rộng Kẻ Sọc', 'Sơ Mi Lụa / Nhăn', 'Polo Form Boxy Cổ Khóa Zip', 'Polo Dệt Kim (Knit Polo)']
  },
  {
    category: 'ÁO KHOÁC (OUTERWEAR)',
    items: ['Khoác Bomber Varsity', 'Jacket Da / Faux Leather', 'Khoác Dù Parachute', 'Cardigan Dệt Kim Thủng', 'Hoodie Zip Oversize', 'Áo Khoác Nỉ Form Rộng']
  },
  {
    category: 'ÁO KIỂU KHÁC',
    items: ['Áo Tank Top Khoét Sâu', 'Áo Len Gile (Vest Len)', 'Sweater Cổ Tròn Form Rộng', 'Áo Lưới / Xuyên Thấu Lớp Trong']
  }
])

// 4. QUẦN (Mở rộng & cập nhật form Gen Z)
const menuQuan = ref([
  {
    category: 'QUẦN JEAN / DENIM',
    items: ['Jean Ống Rộng (Baggy Jeans)', 'Jean Ống Loe (Flared Jeans)', 'Jean Wash Bạc / Rách Gối', 'Jorts (Quần Short Jean Dài Khóa Gối)']
  },
  {
    category: 'QUẦN VẢI / KAKI',
    items: ['Quần Túi Hộp (Cargo Pants)', 'Quần Dù (Parachute Pants)', 'Quần Ống Bí (Balloon Pants)', 'Quần Ống Cong (Curved Pants)', 'Quần Tây Ống Suông Trơn']
  },
  {
    category: 'QUẦN SHORT / SWEATPANTS',
    items: ['Short Nỉ Phom Rộng', 'Short Dù Thể Thao', 'Quần Nỉ Dài (Sweatpants) Dây Rút', 'Quần Trackpants 2 Sọc']
  }
])

// 5. PHỤ KIỆN (Bổ sung phụ kiện trend)
const menuPhuKien = ref([
  {
    category: 'MŨ & TÚI',
    items: ['Mũ Beanie (Mũ Len)', 'Mũ Lưỡi Trai Chữ Thêu', 'Túi Tote Canvas Lớn', 'Túi Đeo Chéo (Crossbody / Messenger)']
  },
  {
    category: 'TRANG SỨC & KHÁC',
    items: ['Dây Chuyền / Nhẫn Bạc Bản To', 'Thắt Lưng Đinh Tán / Y2K', 'Tất Ống Chân (Leg Warmers)', 'Tất Cổ Cao Trắng / Đen', 'Nước Hoa Body Mist']
  }
])
</script>

<template>
  <header class="bg-[#f8f4f0] border-b border-[#e9ddd2] sticky top-0 z-50">
    <div class="mx-auto w-full max-w-[1400px] px-6 md:px-10 flex justify-between items-center h-16 relative">
      
      <div class="flex items-center gap-3 cursor-pointer group">
        <div class="w-11 h-11 rounded-full overflow-hidden bg-white border border-white/80 shadow-inner flex items-center justify-center group-hover:opacity-80 transition duration-300">
          <img src="/images/AppHeader/logo.jpeg" alt="ChongDoo Logo" class="w-15 h-15 object-contain">
        </div>
        <span class="text-2xl font-black tracking-tighter text-slate-900 group-hover:text-slate-700 transition">ChongDoo</span>
      </div>

      <nav class="hidden md:flex gap-8 text-sm font-semibold text-gray-700 uppercase tracking-wide h-full">
        
        <div class="flex items-center h-full group cursor-pointer">
          <a class="hover:text-red-500 text-red-600 transition px-1 flex items-center gap-1 h-full">
            SALE <span class="text-[10px] group-hover:rotate-180 transition-transform duration-300">▼</span>
          </a>
          <div class="absolute top-full left-1/2 -translate-x-1/2 w-max bg-white border border-gray-200 shadow-xl opacity-0 invisible translate-y-4 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition-all duration-300 z-50 p-8 rounded-b-xl flex gap-12 cursor-default">
            <div v-for="(col, index) in menuSale" :key="index" class="w-56">
              <h3 class="font-bold text-red-600 text-sm mb-4 pb-2 border-b border-gray-200">{{ col.category }}</h3>
              <ul class="flex flex-col gap-3">
                <li v-for="(item, idx) in col.items" :key="idx">
                  <a href="#" class="text-gray-500 font-normal hover:text-red-500 hover:translate-x-1 inline-block transition-all text-[13px] capitalize">{{ item }}</a>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <div class="flex items-center h-full group cursor-pointer">
          <a class="hover:text-black transition px-1 flex items-center gap-1 h-full">
            TRANG PHỤC <span class="text-[10px] group-hover:rotate-180 transition-transform duration-300">▼</span>
          </a>
          <div class="absolute top-full left-1/2 -translate-x-1/2 w-max bg-white border border-gray-200 shadow-xl opacity-0 invisible translate-y-4 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition-all duration-300 z-50 p-8 rounded-b-xl flex gap-12 cursor-default">
            <div v-for="(col, index) in menuTrangPhuc" :key="index" class="w-56">
              <h3 class="font-bold text-slate-800 text-sm mb-4 pb-2 border-b border-gray-200">{{ col.category }}</h3>
              <ul class="flex flex-col gap-3">
                <li v-for="(item, idx) in col.items" :key="idx">
                  <a href="#" class="text-gray-500 font-normal hover:text-black hover:translate-x-1 inline-block transition-all text-[13px] capitalize">{{ item }}</a>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <div class="flex items-center h-full group cursor-pointer">
          <a class="hover:text-black transition px-1 flex items-center gap-1 h-full">
            ÁO <span class="text-[10px] group-hover:rotate-180 transition-transform duration-300">▼</span>
          </a>
          <div class="absolute top-full left-1/2 -translate-x-1/2 w-max bg-white border border-gray-200 shadow-xl opacity-0 invisible translate-y-4 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition-all duration-300 z-50 p-8 rounded-b-xl flex gap-12 cursor-default">
            <div v-for="(col, index) in menuAo" :key="index" class="w-56">
              <h3 class="font-bold text-slate-800 text-sm mb-4 pb-2 border-b border-gray-200">{{ col.category }}</h3>
              <ul class="flex flex-col gap-3">
                <li v-for="(item, idx) in col.items" :key="idx">
                  <a href="#" class="text-gray-500 font-normal hover:text-black hover:translate-x-1 inline-block transition-all text-[13px] capitalize">{{ item }}</a>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <div class="flex items-center h-full group cursor-pointer">
          <a class="hover:text-black transition px-1 flex items-center gap-1 h-full">
            QUẦN <span class="text-[10px] group-hover:rotate-180 transition-transform duration-300">▼</span>
          </a>
          <div class="absolute top-full left-1/2 -translate-x-1/2 w-max bg-white border border-gray-200 shadow-xl opacity-0 invisible translate-y-4 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition-all duration-300 z-50 p-8 rounded-b-xl flex gap-12 cursor-default">
            <div v-for="(col, index) in menuQuan" :key="index" class="w-56">
              <h3 class="font-bold text-slate-800 text-sm mb-4 pb-2 border-b border-gray-200">{{ col.category }}</h3>
              <ul class="flex flex-col gap-3">
                <li v-for="(item, idx) in col.items" :key="idx">
                  <a href="#" class="text-gray-500 font-normal hover:text-black hover:translate-x-1 inline-block transition-all text-[13px] capitalize">{{ item }}</a>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <div class="flex items-center h-full group cursor-pointer">
          <a class="hover:text-black transition px-1 flex items-center gap-1 h-full">
            PHỤ KIỆN <span class="text-[10px] group-hover:rotate-180 transition-transform duration-300">▼</span>
          </a>
          <div class="absolute top-full left-1/2 -translate-x-1/2 w-max bg-white border border-gray-200 shadow-xl opacity-0 invisible translate-y-4 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition-all duration-300 z-50 p-8 rounded-b-xl flex gap-12 cursor-default">
            <div v-for="(col, index) in menuPhuKien" :key="index" class="w-56">
              <h3 class="font-bold text-slate-800 text-sm mb-4 pb-2 border-b border-gray-200">{{ col.category }}</h3>
              <ul class="flex flex-col gap-3">
                <li v-for="(item, idx) in col.items" :key="idx">
                  <a href="#" class="text-gray-500 font-normal hover:text-black hover:translate-x-1 inline-block transition-all text-[13px] capitalize">{{ item }}</a>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <a href="#" class="flex items-center hover:text-black transition px-1 h-full">CỬA HÀNG</a>
        
      </nav>

      <div class="flex items-center gap-2">

        <!-- ── Nút Tìm Kiếm ── -->
        <button
          @click="isSearchOpen = true"
          aria-label="Tìm kiếm"
          class="w-11 h-11 flex items-center justify-center text-black hover:text-slate-600 hover:bg-black/5 rounded-full transition"
        >
          <svg viewBox="0 0 24 24" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="7"></circle><path d="M21 21l-4.35-4.35"></path>
          </svg>
        </button>

        <!-- ── Nút Tài Khoản ── -->
        <div class="relative">
          <button
            @click="handleAccountClick"
            aria-label="Tài khoản"
            class="w-11 h-11 flex items-center justify-center hover:bg-black/5 rounded-full transition"
          >
            <!-- Avatar khi đã đăng nhập -->
            <div v-if="isLoggedIn" class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center text-sm font-black">
              {{ userInitial }}
            </div>
            <!-- Icon mặc định -->
            <svg v-else viewBox="0 0 24 24" class="w-5 h-5 text-black" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="8" r="3"></circle><path d="M5.5 20c0-3.59 2.91-6.5 6.5-6.5s6.5 2.91 6.5 6.5"></path>
            </svg>
          </button>

          <!-- Dropdown khi đã đăng nhập -->
          <Transition name="dropdown">
            <div
              v-if="isLoggedIn && isUserDropdownOpen"
              class="absolute right-0 top-full mt-2 w-52 bg-white border border-gray-100 rounded-2xl shadow-xl py-2 z-50"
            >
              <div class="px-4 py-3 border-b border-gray-100">
                <p class="text-xs font-black text-slate-900">{{ currentUser?.name }}</p>
                <p class="text-[11px] text-gray-400 truncate">{{ currentUser?.email }}</p>
              </div>
              <a href="#" class="flex items-center gap-3 px-4 py-2.5 hover:bg-[#f8f4f0] transition text-sm text-slate-700 font-medium">
                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                Trang Cá Nhân
              </a>
              <a href="#" class="flex items-center gap-3 px-4 py-2.5 hover:bg-[#f8f4f0] transition text-sm text-slate-700 font-medium">
                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                Đơn Hàng Của Tôi
              </a>
              <button @click="handleLogout" class="w-full flex items-center gap-3 px-4 py-2.5 hover:bg-red-50 transition text-sm text-red-500 font-medium">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                Đăng Xuất
              </button>
            </div>
          </Transition>
        </div>

        <!-- ── Nút Giỏ Hàng ── -->
        <button
          @click="openCart"
          aria-label="Giỏ hàng"
          class="relative w-11 h-11 flex items-center justify-center text-black hover:text-slate-600 hover:bg-black/5 rounded-full transition"
        >
          <svg viewBox="0 0 24 24" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 7h12l1 12H5L6 7z"></path><path d="M9 7V5a3 3 0 0 1 6 0v2"></path>
          </svg>
          <!-- Badge số lượng -->
          <Transition name="badge">
            <span
              v-if="cartCount > 0"
              class="absolute -top-0.5 -right-0.5 bg-[#e3342f] text-white text-[10px] font-black w-5 h-5 rounded-full flex items-center justify-center shadow-sm"
            >
              {{ cartCount > 99 ? '99+' : cartCount }}
            </span>
          </Transition>
        </button>

      </div>

      <!-- ── Modals (rendered in header, teleported to body via CartDrawer) ── -->
      <Teleport to="body">
        <SearchModal v-if="isSearchOpen" @close="isSearchOpen = false" />
        <AuthModal v-if="isAuthOpen" @close="isAuthOpen = false" />
      </Teleport>

    </div>
  </header>
</template>

<style scoped>
/* Badge pop animation */
.badge-enter-active { animation: badgePop 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); }
.badge-leave-active { transition: all 0.15s ease; }
.badge-leave-to { transform: scale(0); opacity: 0; }
@keyframes badgePop { from { transform: scale(0); } to { transform: scale(1); } }

/* Dropdown fade+slide */
.dropdown-enter-active { animation: dropDown 0.2s cubic-bezier(0.16, 1, 0.3, 1); }
.dropdown-leave-active { transition: all 0.15s ease; }
.dropdown-leave-to { transform: translateY(-8px); opacity: 0; }
@keyframes dropDown { from { transform: translateY(-8px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
</style>