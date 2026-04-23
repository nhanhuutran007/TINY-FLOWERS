<script setup>
import { ref } from 'vue'
import { useCart } from '../composables/useCart.js'

const { addToCart } = useCart()

// Toast notification
const toastMsg = ref('')
const showToast = ref(false)
let toastTimer
const triggerToast = (msg) => {
  toastMsg.value = msg
  showToast.value = true
  clearTimeout(toastTimer)
  toastTimer = setTimeout(() => { showToast.value = false }, 2500)
}

// 1. DỮ LIỆU ĐÃ ĐƯỢC BỔ SUNG GIÁ TIỀN
const styleItems = ref([
  {
    id: 1,
    title: 'SET TONE ĐEN',
    subtitle: 'Sắp xếp nhanh bộ đồ thanh lịch, dễ phối cho cả ngày dài.',
    price: '750.000đ',
    image: '/images/StyleSetSection/f1.png',
    button: 'PHỐI NGAY'
  },
  {
    id: 2,
    title: 'SET TONE TRẮNG',
    subtitle: 'Bộ đôi neutral luôn sang, phù hợp mọi buổi hẹn và gặp gỡ.',
    price: '680.000đ',
    image: '/images/StyleSetSection/f2.png',
    button: 'XEM NGAY'
  },
  {
    id: 3,
    title: 'SET TONE NÂU ĐẤT',
    subtitle: 'Ấm áp và nhẹ nhàng, mang đến cảm giác thời thượng mà vẫn dễ chịu.',
    price: '820.000đ',
    image: '/images/StyleSetSection/f3.png',
    button: 'THỬ PHONG CÁCH'
  }
])

// 2. BIẾN QUẢN LÝ MODAL VÀ SIZE
const isModalOpen = ref(false)
const selectedProduct = ref(null)

// Danh sách các size và size đang được chọn (mặc định là L)
const sizes = ['S', 'M', 'L', 'XL', 'XXL']
const selectedSize = ref('L')

// Hàm mở modal
const openProductModal = (item) => {
  selectedProduct.value = item
  selectedSize.value = 'L' // Reset về size L mỗi khi mở modal mới
  isModalOpen.value = true
}

// Hàm đóng modal
const closeProductModal = () => {
  isModalOpen.value = false
  selectedProduct.value = null
}

// Thêm vào giỏ từ modal (chuyển đổi styleItem → product object)
const handleAddFromModal = () => {
  if (!selectedProduct.value) return
  const product = {
    id: `style-${selectedProduct.value.id}`,
    name: selectedProduct.value.title,
    price: selectedProduct.value.price,
    image: selectedProduct.value.image,
    tag: 'STYLE SET'
  }
  addToCart(product, selectedSize.value)
  triggerToast(`Đã thêm "${selectedProduct.value.title}" vào giỏ hàng! 🛒`)
  closeProductModal()
}
</script>

<template>
  <section class="w-full py-16 bg-[#fff8f3]">

    <!-- Toast -->
    <Teleport to="body">
      <Transition name="toast">
        <div v-if="showToast" class="fixed bottom-6 left-1/2 -translate-x-1/2 z-[500] bg-slate-900 text-white text-sm font-semibold px-6 py-3.5 rounded-full shadow-2xl flex items-center gap-3 whitespace-nowrap">
          <svg class="w-4 h-4 text-green-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
          {{ toastMsg }}
        </div>
      </Transition>
    </Teleport>

    <div class="max-w-7xl mx-auto px-4">
      
      <div class="mb-14 text-center">
        <h2 class="text-3xl md:text-5xl font-light uppercase text-slate-900 tracking-wide mb-4">
          STYLE SET <span class="text-[#705847]">ĐỘC QUYỀN</span>
        </h2>
        <p class="text-slate-700 font-light text-base md:text-lg opacity-90 max-w-2xl mx-auto">
          Mỗi set là một gợi ý phối đồ tinh gọn, dễ áp dụng với phong cách hiện đại và chất riêng của bạn.
        </p>
      </div>

      <div class="grid gap-6 lg:grid-cols-3">
        <div v-for="item in styleItems" :key="item.id" @click="openProductModal(item)" class="group cursor-pointer overflow-hidden hover:-translate-y-2 transition-transform duration-300">
          
          <div class="aspect-[4/5] bg-white rounded-3xl shadow-sm border border-black/5 flex items-center justify-center p-6 relative overflow-hidden">
            <div class="absolute inset-0 bg-[#f8f4f0] opacity-50"></div>
            <img :src="item.image" :alt="item.title" class="relative z-10 w-full h-full object-contain group-hover:scale-105 transition duration-700">
          </div>
          
          <div class="p-6 text-center">
            <h3 class="font-medium text-lg text-slate-900 mb-2 tracking-wide">{{ item.title }}</h3>
            <p class="text-sm text-slate-600 mb-5 font-light">{{ item.subtitle }}</p>
            
            <button class="rounded-full border border-slate-900 px-6 py-2.5 text-[13px] font-medium uppercase tracking-wider text-slate-900 group-hover:bg-slate-900 group-hover:text-white transition-all duration-300">
              {{ item.button }}
            </button>
          </div>
          
        </div>
      </div>
      
    </div>
  </section>

  <div v-if="isModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="closeProductModal"></div>
    
    <div class="relative bg-white rounded-3xl shadow-2xl max-w-4xl w-full p-8 md:p-12 overflow-hidden flex flex-col md:flex-row gap-8 md:gap-12 z-10">
      
      <button @click="closeProductModal" class="absolute top-6 right-6 text-slate-400 hover:text-slate-900 transition bg-gray-100 hover:bg-gray-200 rounded-full p-2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
      </button>
      
      <div class="md:w-1/2 aspect-[4/5] rounded-2xl overflow-hidden bg-gradient-to-b from-[#f8f4f0] to-[#f3e7dd] flex-shrink-0 border border-black/5 shadow-inner p-6 relative flex items-center justify-center">
        <img :src="selectedProduct?.image" :alt="selectedProduct?.title" class="w-full h-full object-contain drop-shadow-md">
      </div>
      
      <div class="md:w-1/2 flex flex-col justify-center">
        <span class="text-sm text-[#705847] mb-2 uppercase tracking-widest font-light">Mua Nguyên Set</span>
        <h3 class="text-3xl md:text-4xl font-black text-slate-900 mb-4 uppercase tracking-tighter leading-tight">{{ selectedProduct?.title }}</h3>
        <p class="text-sm text-slate-600 font-light mb-6">{{ selectedProduct?.subtitle }}</p>
        
        <p class="text-2xl font-black text-slate-700 mb-8">{{ selectedProduct?.price }}</p>
        
        <div class="mb-10">
          <div class="flex justify-between items-center mb-4">
            <span class="text-sm font-bold text-slate-900 uppercase tracking-wider">Kích Thước:</span>
            <span class="text-xs text-gray-500 underline cursor-pointer hover:text-black">Bảng size chuẩn</span>
          </div>
          
          <div class="flex flex-wrap gap-3">
            <button 
              v-for="size in sizes" 
              :key="size"
              @click="selectedSize = size"
              :class="selectedSize === size ? 'bg-slate-900 text-white border-slate-900' : 'bg-white text-slate-700 border-gray-300 hover:border-slate-900'"
              class="w-12 h-12 rounded-xl border flex items-center justify-center font-medium transition-all duration-200"
            >
              {{ size }}
            </button>
          </div>
        </div>
        
        <div class="flex flex-col gap-4">
            <button @click="handleAddFromModal" class="w-full bg-[#705847] text-white font-bold py-4 rounded-full shadow-lg hover:bg-slate-900 transition duration-300 uppercase tracking-wider">
              THÊM VÀO GIỎ HÀNG
            </button>
          </div>
      </div>
      
    </div>
  </div>
</template>

<style scoped>
.toast-enter-active { animation: toastIn 0.35s cubic-bezier(0.34, 1.56, 0.64, 1); }
.toast-leave-active { transition: all 0.25s ease; }
.toast-leave-to { transform: translateX(-50%) translateY(20px); opacity: 0; }
@keyframes toastIn {
  from { transform: translateX(-50%) translateY(20px); opacity: 0; }
  to   { transform: translateX(-50%) translateY(0);    opacity: 1; }
}
</style>