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

// 1. KHO DỮ LIỆU SET ĐỒ (Đã được cập nhật tên xịn xò)
const matchProducts = ref([
  { id: 1, name: 'Set "Cozy Boy": Cardigan Lông Màu Gradient & Quần Suông Đen', price: '450.000đ', image: '/images/MatchReadySection/f2.png' },
  { id: 2, name: 'Outfit "Cháy Phố": Jacket Đỏ Boxy Lửng & Baggy Lả Lướt', price: '520.000đ', image: '/images/MatchReadySection/f3.png' },
  { id: 3, name: 'Combo "Good Boy": Cardigan Len Mỏng & Quần Âu', price: '480.000đ', image: '/images/MatchReadySection/f4.png' },
  { id: 4, name: 'Set "Y2K Vibe": Polo Dệt Kim Cộc Tay & Jean Siêu Thụng', price: '750.000đ', image: '/images/MatchReadySection/f5.png' },
  { id: 5, name: 'Outfit "Thu Cổ Điển": Suede Jacket Da Lộn Nâu & Quần Suông', price: '320.000đ', image: '/images/MatchReadySection/f6.png' },
  { id: 6, name: 'Set "Thư Sinh": Sơ Mi Layer Sáng Màu Phối Áo Xanh Cổ Lọ', price: '390.000đ', image: '/images/MatchReadySection/f7.png' },
  { id: 7, name: 'Combo "Dạo Phố Đêm": Áo Dệt Kim Xám Khói & Quần Dù Parachute', price: '410.000đ', image: '/images/MatchReadySection/f8.png' },
  { id: 8, name: 'Outfit "Darkwear": Jacket Cổ Trụ Khóa Cài Kim Loại & Quần Đen', price: '550.000đ', image: '/images/MatchReadySection/f9.png' },
  { id: 9, name: 'Set "Quyền Lực Ngầm": Suit Đỏ Rượu Vang Dáng Thụng Sang Trọng', price: '620.000đ', image: '/images/MatchReadySection/f10.png' },
  { id: 10, name: 'Combo "Tối Giản Sang Trọng": Jacket Cropped Tối Màu & Áo Cổ Lọ Đen', price: '350.000đ', image: '/images/MatchReadySection/f11.png' }
])

const sliderRef = ref(null)
const scrollBy = (distance) => {
  if (!sliderRef.value) return
  sliderRef.value.scrollBy({ left: distance, behavior: 'smooth' })
}

// 2. BIẾN QUẢN LÝ MODAL VÀ SIZE
const isModalOpen = ref(false)
const selectedProduct = ref(null)

const sizes = ['S', 'M', 'L', 'XL', 'XXL']
const selectedSize = ref('L')

const openProductModal = (product) => {
  selectedProduct.value = product
  selectedSize.value = 'L' // Reset về size L mỗi khi mở modal
  isModalOpen.value = true
}

const closeProductModal = () => {
  isModalOpen.value = false
  selectedProduct.value = null
}

// Thêm vào giỏ từ modal
const handleAddFromModal = () => {
  if (!selectedProduct.value) return
  addToCart(selectedProduct.value, selectedSize.value)
  triggerToast(`Đã thêm "${selectedProduct.value.name.slice(0, 30)}..." vào giỏ! 🛒`)
  closeProductModal()
}

// 3. HÀM CHUYỂN TRANG
const goToMatchCollection = () => {
  window.location.href = '/collection?type=match'
}
</script>

<template>
  <section class="w-full py-20 bg-[#f3e7dd]">

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
          PHỐI ĐỒ 3 GIÂY <span class="text-[#705847]">KHÔNG LO NGHĨ</span>
        </h2>
        <p class="text-slate-700 font-light text-base md:text-lg opacity-90 max-w-2xl mx-auto">
          Chọn ngay set đồ đã được ChongDoo chuẩn bị sẵn, dễ mặc, dễ mix, hợp mọi phong thái và mọi địa điểm.
        </p>
      </div>

      <div class="relative mb-12">
        <button @click="scrollBy(-320)" class="absolute left-0 top-1/2 -translate-y-1/2 z-10 h-12 w-12 rounded-full bg-white/80 text-slate-600 hover:text-slate-900 border border-white hover:bg-white shadow-sm transition flex items-center justify-center">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
        </button>
        <button @click="scrollBy(320)" class="absolute right-0 top-1/2 -translate-y-1/2 z-10 h-12 w-12 rounded-full bg-white/80 text-slate-600 hover:text-slate-900 border border-white hover:bg-white shadow-sm transition flex items-center justify-center">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
        </button>
        
        <div ref="sliderRef" class="flex gap-5 overflow-x-auto scroll-smooth px-8 py-2 hide-scrollbar">
          <div v-for="item in matchProducts" :key="item.id" @click="openProductModal(item)" class="min-w-[180px] md:min-w-[200px] cursor-pointer hover:-translate-y-1 transition duration-300 relative">
            <div class="aspect-[2/3] overflow-hidden rounded-2xl shadow-sm border border-white/50 relative">
              <img :src="item.image" :alt="item.name" class="absolute inset-0 w-full h-full object-cover hover:scale-110 transition duration-700" />
            </div>
          </div>
        </div>
      </div>

      <div class="text-center">
        <button @click="goToMatchCollection" class="rounded-full border border-slate-900 px-10 py-3 text-[13px] font-medium uppercase tracking-wider text-slate-900 hover:bg-slate-900 hover:text-white transition-all duration-300">
          Phối đồ ngay
        </button>
      </div>
      
    </div>
  </section>

  <div v-if="isModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="closeProductModal"></div>
    <div class="relative bg-white rounded-3xl shadow-2xl max-w-4xl w-full p-8 md:p-12 overflow-hidden flex flex-col md:flex-row gap-8 md:gap-12 z-10">
      
      <button @click="closeProductModal" class="absolute top-6 right-6 text-slate-400 hover:text-slate-900 transition bg-gray-100 hover:bg-gray-200 rounded-full p-2 z-20">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
      </button>
      
      <div class="md:w-1/2 aspect-[3/4] rounded-2xl overflow-hidden bg-gray-100 flex-shrink-0 border border-white/50 shadow-sm">
        <img :src="selectedProduct?.image" :alt="selectedProduct?.name" class="w-full h-full object-cover">
      </div>
      
      <div class="md:w-1/2 flex flex-col justify-center">
        <span class="text-sm text-[#705847] mb-2 uppercase tracking-widest font-light">Gợi Ý Phối Đồ</span>
        <h3 class="text-3xl font-black text-slate-900 mb-6 uppercase tracking-tighter leading-tight">{{ selectedProduct?.name }}</h3>
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
          <button @click="handleAddFromModal" class="w-full bg-slate-900 text-white font-bold py-4 rounded-full shadow-lg hover:bg-slate-700 transition duration-300 uppercase tracking-wider">
            THÊM VÀO GIỎ HÀNG
          </button>
          <button @click="closeProductModal" class="w-full border border-gray-300 text-slate-700 font-medium py-4 rounded-full hover:bg-gray-100 transition duration-300 uppercase tracking-wider text-xs">
            Tiếp tục xem đồ
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.hide-scrollbar::-webkit-scrollbar { display: none; }
.hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

.toast-enter-active { animation: toastIn 0.35s cubic-bezier(0.34, 1.56, 0.64, 1); }
.toast-leave-active { transition: all 0.25s ease; }
.toast-leave-to { transform: translateX(-50%) translateY(20px); opacity: 0; }
@keyframes toastIn {
  from { transform: translateX(-50%) translateY(20px); opacity: 0; }
  to   { transform: translateX(-50%) translateY(0);    opacity: 1; }
}
</style>