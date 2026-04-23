<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useCart } from '../composables/useCart.js'

const { addToCart } = useCart()

// 1. KHO DỮ LIỆU ĐÃ ĐƯỢC CẬP NHẬT CHUẨN XÁC TỪ ẢNH THỰC TẾ
const jackets = ref([
  { id: 1, name: 'Áo Khoác Dù Parachute Bụi Bặm', price: '193.000đ', oldPrice: '350.000đ', image: '/images/SalePage/j1.png', tag: 'FLASH SALE' },
  { id: 2, name: 'Áo Khoác Gió Form Boxy Phối Trắng', price: '210.000đ', oldPrice: '380.000đ', image: '/images/SalePage/j2.png', tag: '-40%' },
  { id: 3, name: 'Áo Khoác Chống Nắng UV Phom Rộng', price: '185.000đ', oldPrice: '290.000đ', image: '/images/SalePage/j3.png', tag: 'FLASH SALE' },
  { id: 4, name: 'Áo Khoác Nhẹ Cổ Đứng Minimal', price: '220.000đ', oldPrice: '400.000đ', image: '/images/SalePage/j4.png', tag: '-30%' },
  { id: 5, name: 'Áo Khoác Denim Đen Wash Rách', price: '250.000đ', oldPrice: '450.000đ', image: '/images/SalePage/j5.png', tag: 'FLASH SALE' },
  { id: 6, name: 'Áo Khoác Bomber Da PU Cao Cấp', price: '320.000đ', oldPrice: '550.000đ', image: '/images/SalePage/j6.png', tag: '-50%' },
  { id: 7, name: 'Áo Khoác Nỉ Form Thụng Varsity', price: '199.000đ', oldPrice: '350.000đ', image: '/images/SalePage/j7.png', tag: '-40%' },
  { id: 8, name: 'Jacket Kaki Mỏng Mùa Thu Nhẹ Nhàng', price: '215.000đ', oldPrice: '380.000đ', image: '/images/SalePage/j8.png', tag: 'FLASH SALE' }
])

const tshirts = ref([
  { id: 11, name: 'Áo Thun Cotton Mát Lạnh Thoáng Khí', price: '99.000đ', oldPrice: '150.000đ', image: '/images/SalePage/t1.png', tag: 'MUA KÈM DEAL SỐC' },
  { id: 12, name: 'Áo Baby Tee Thêu Logo Nổi Bật', price: '120.000đ', oldPrice: '200.000đ', image: '/images/SalePage/t2.png', tag: '-40%' },
  { id: 13, name: 'Áo Thun Drop Shoulder Dáng Thụng', price: '149.000đ', oldPrice: '250.000đ', image: '/images/SalePage/t3.png', tag: 'HOT' },
  { id: 14, name: 'Áo Thun Wash Bụi Phong Cách Đường Phố', price: '169.000đ', oldPrice: '280.000đ', image: '/images/SalePage/t4.png', tag: '-50%' },
  { id: 15, name: 'Polo Zip Vải Mắt Chim Hút Mồ Hôi', price: '155.000đ', oldPrice: '260.000đ', image: '/images/SalePage/t5.png', tag: 'FLASH SALE' },
  { id: 16, name: 'Áo Thun Graphic In Nổi Y2K', price: '135.000đ', oldPrice: '220.000đ', image: '/images/SalePage/t6.png', tag: '-30%' },
  { id: 17, name: 'Tank Top Thể Thao Siêu Nhẹ', price: '89.000đ', oldPrice: '150.000đ', image: '/images/SalePage/t7.png', tag: 'DEAL SỐC' },
  { id: 18, name: 'Áo Thun Trơn Basic Dễ Phối Đồ', price: '110.000đ', oldPrice: '180.000đ', image: '/images/SalePage/t8.png', tag: '-40%' }
])

// 2. BIẾN QUẢN LÝ "XEM THÊM" / "THU GỌN"
const showAllJackets = ref(false)
const showAllTshirts = ref(false)

const visibleJackets = computed(() => showAllJackets.value ? jackets.value : jackets.value.slice(0, 4))
const visibleTshirts = computed(() => showAllTshirts.value ? tshirts.value : tshirts.value.slice(0, 4))

// 3. BIẾN QUẢN LÝ MODAL VÀ SIZE
const isModalOpen = ref(false)
const selectedProduct = ref(null)
const sizes = ['S', 'M', 'L', 'XL', 'XXL']
const selectedSize = ref('L')

const openProductModal = (product) => {
  selectedProduct.value = product
  selectedSize.value = 'L'
  isModalOpen.value = true
}

const closeProductModal = () => {
  isModalOpen.value = false
  selectedProduct.value = null
}

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

// Thêm vào giỏ từ card sản phẩm (MUA NGAY)
const handleQuickAdd = (product, event) => {
  event.stopPropagation()
  addToCart(product, 'L')
  triggerToast(`Đã thêm "${product.name.slice(0, 25)}..." vào giỏ!`)
}

// Thêm vào giỏ từ modal (CHỐT DEAL NGAY)
const handleAddFromModal = () => {
  if (!selectedProduct.value) return
  addToCart(selectedProduct.value, selectedSize.value)
  triggerToast(`Đã thêm vào giỏ hàng! 🛒`)
  closeProductModal()
}

// 4. BỘ ĐẾM NGƯỢC THỜI GIAN SALE (COUNTDOWN TIMER)
const hours = ref(14)
const minutes = ref(35)
const seconds = ref(59)
let timerInterval

const padTime = (val) => {
  return val < 10 ? '0' + val : val
}

onMounted(() => {
  timerInterval = setInterval(() => {
    if (seconds.value > 0) {
      seconds.value--
    } else {
      seconds.value = 59
      if (minutes.value > 0) {
        minutes.value--
      } else {
        minutes.value = 59
        if (hours.value > 0) hours.value--
      }
    }
  }, 1000)
})

onUnmounted(() => {
  clearInterval(timerInterval)
})
</script>

<template>
  <div class="w-full bg-[#f8f4f0] pb-20">

    <!-- Toast Notification -->
    <Teleport to="body">
      <Transition name="toast">
        <div v-if="showToast" class="fixed bottom-6 left-1/2 -translate-x-1/2 z-[500] bg-slate-900 text-white text-sm font-semibold px-6 py-3.5 rounded-full shadow-2xl flex items-center gap-3 whitespace-nowrap">
          <svg class="w-4 h-4 text-green-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
          </svg>
          {{ toastMsg }}
        </div>
      </Transition>
    </Teleport>


    <div class="w-full bg-slate-900 text-white py-6 md:py-8 mb-10">
      <div class="max-w-[1400px] mx-auto px-4 md:px-10 flex flex-col md:flex-row items-center justify-between gap-6">
        
        <div class="text-center md:text-left">
          <h1 class="text-3xl md:text-4xl font-black mb-1 uppercase tracking-widest text-white">
            SALE MÁT MẺ, <span class="text-white">GIÁ CỰC RẺ</span>
          </h1>
          <p class="text-gray-300 text-sm font-medium">Cộng dồn giảm thêm 10% thẻ VIP khi mua sắm tại cửa hàng</p>
        </div>

        <div class="flex items-center gap-3 font-mono">
          <span class="text-sm font-bold uppercase tracking-widest text-gray-300 mr-2 hidden lg:block">Kết thúc sau:</span>
          <div class="flex flex-col items-center">
            <span class="bg-white text-slate-900 px-4 py-2.5 rounded-xl text-2xl leading-none font-black shadow-inner">{{ padTime(hours) }}</span>
            <span class="text-[10px] mt-1.5 font-sans text-gray-400 tracking-widest">GIỜ</span>
          </div>
          <span class="text-white pb-5 font-black text-2xl">:</span>
          <div class="flex flex-col items-center">
            <span class="bg-white text-slate-900 px-4 py-2.5 rounded-xl text-2xl leading-none font-black shadow-inner">{{ padTime(minutes) }}</span>
            <span class="text-[10px] mt-1.5 font-sans text-gray-400 tracking-widest">PHÚT</span>
          </div>
          <span class="text-white pb-5 font-black text-2xl">:</span>
          <div class="flex flex-col items-center">
            <span class="bg-[#e3342f] text-white px-4 py-2.5 rounded-xl text-2xl leading-none font-black shadow-inner">{{ padTime(seconds) }}</span>
            <span class="text-[10px] mt-1.5 font-sans text-white tracking-widest font-bold">GIÂY</span>
          </div>
        </div>
        
      </div>
    </div>

    <div class="max-w-[1400px] mx-auto px-4 md:px-10 grid grid-cols-1 md:grid-cols-2 gap-4 my-10">
      <div class="h-[400px] bg-gray-200 rounded-2xl overflow-hidden relative shadow-sm">
        <img src="/images/SalePage/banner1.png" alt="Banner 1" class="w-full h-full object-cover hover:scale-105 transition duration-700">
      </div>
      <div class="h-[400px] bg-gray-200 rounded-2xl overflow-hidden relative shadow-sm">
        <img src="/images/SalePage/banner2.png" alt="Banner 2" class="w-full h-full object-cover hover:scale-105 transition duration-700">
      </div>
    </div>

    <section class="max-w-[1400px] mx-auto px-4 md:px-10 mb-20 bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100">
      <h2 class="text-center text-2xl md:text-3xl font-black mb-10 uppercase tracking-widest text-slate-900 pb-4 inline-block mx-auto border-b-2 border-white/50">
         Áo Khoác Trendy 
      </h2>
      
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6 mb-10">
        <div v-for="item in visibleJackets" :key="item.id" @click="openProductModal(item)" class="group cursor-pointer flex flex-col">
          <div class="aspect-[3/4] bg-gray-50 mb-4 overflow-hidden relative rounded-2xl shadow-sm border border-red-50">
            <img :src="item.image" :alt="item.name" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
            
            <div v-if="item.tag" class="absolute top-3 left-3 bg-[#e3342f] text-white text-[10px] font-bold px-2 py-1.5 rounded uppercase tracking-wider shadow-sm">
              {{ item.tag }}
            </div>
            
            <div class="absolute bottom-0 left-0 w-full p-3 opacity-0 group-hover:opacity-100 translate-y-4 group-hover:translate-y-0 transition-all duration-300">
              <button @click="handleQuickAdd(item, $event)" class="w-full bg-white/95 backdrop-blur text-[#e3342f] text-[11px] font-bold py-3 rounded-full shadow-lg hover:bg-[#e3342f] hover:text-white transition border border-[#e3342f]/20">
                MUA NGAY
              </button>
            </div>
          </div>
          
          <h3 class="text-xs md:text-sm font-medium text-slate-900 line-clamp-2 mb-1 group-hover:text-[#e3342f] transition">{{ item.name }}</h3>
          <div class="flex items-baseline gap-2 mt-auto">
            <span class="text-[#e3342f] font-black text-sm md:text-base">{{ item.price }}</span>
            <span class="text-gray-400 text-xs font-medium line-through">{{ item.oldPrice }}</span>
          </div>
        </div>
      </div>

      <div class="flex justify-center">
        <button @click="showAllJackets = !showAllJackets" class="border-2 border-slate-900 text-slate-900 px-10 py-3 text-xs font-bold hover:bg-slate-900 hover:text-white transition rounded-full uppercase tracking-wider">
          {{ showAllJackets ? 'Thu gọn <<' : 'Xem thêm áo khoác >>' }}
        </button>
      </div>
    </section>

    <div class="max-w-[1400px] mx-auto px-4 md:px-10 grid grid-cols-1 md:grid-cols-2 gap-4 mb-16">
      <div class="h-[300px] bg-gray-200 overflow-hidden relative rounded-2xl shadow-sm">
         <img src="/images/SalePage/banner3.png" class="w-full h-full object-cover hover:scale-105 transition duration-700">
      </div>
      <div class="h-[300px] bg-gray-200 overflow-hidden relative rounded-2xl shadow-sm">
         <img src="/images/SalePage/banner4.png" class="w-full h-full object-cover hover:scale-105 transition duration-700">
      </div>
    </div>

    <section class="max-w-[1400px] mx-auto px-4 md:px-10 mb-10 bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100">
      <h2 class="text-center text-2xl md:text-3xl font-black mb-10 uppercase tracking-widest text-slate-900 pb-4 inline-block mx-auto border-b-2 border-white/50">
         Áo Thun Thời Thượng
      </h2>
      
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6 mb-10">
        <div v-for="item in visibleTshirts" :key="item.id" @click="openProductModal(item)" class="group cursor-pointer flex flex-col">
          <div class="aspect-[3/4] bg-gray-50 mb-4 overflow-hidden relative rounded-2xl shadow-sm border border-red-50">
            <img :src="item.image" :alt="item.name" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
            <div v-if="item.tag" class="absolute top-3 left-3 bg-[#e3342f] text-white text-[10px] font-bold px-2 py-1.5 rounded uppercase tracking-wider shadow-sm">
              {{ item.tag }}
            </div>
          <div class="absolute bottom-0 left-0 w-full p-3 opacity-0 group-hover:opacity-100 translate-y-4 group-hover:translate-y-0 transition-all duration-300">
              <button @click="handleQuickAdd(item, $event)" class="w-full bg-white/95 backdrop-blur text-[#e3342f] text-[11px] font-bold py-3 rounded-full shadow-lg hover:bg-[#e3342f] hover:text-white transition border border-[#e3342f]/20">
                MUA NGAY
              </button>
            </div>
          </div>
          
          <h3 class="text-xs md:text-sm font-medium text-slate-900 line-clamp-2 mb-1 group-hover:text-[#e3342f] transition">{{ item.name }}</h3>
          <div class="flex items-baseline gap-2 mt-auto">
            <span class="text-[#e3342f] font-black text-sm md:text-base">{{ item.price }}</span>
            <span class="text-gray-400 text-xs font-medium line-through">{{ item.oldPrice }}</span>
          </div>
        </div>
      </div>

      <div class="flex justify-center">
        <button @click="showAllTshirts = !showAllTshirts" class="border-2 border-slate-900 text-slate-900 px-10 py-3 text-xs font-bold hover:bg-slate-900 hover:text-white transition rounded-full uppercase tracking-wider">
          {{ showAllTshirts ? 'Thu gọn <<' : 'Xem thêm áo thun >>' }}
        </button>
      </div>
    </section>

  </div>

  <div v-if="isModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="closeProductModal"></div>
    <div class="relative bg-white rounded-3xl shadow-2xl max-w-4xl w-full p-8 md:p-12 overflow-hidden flex flex-col md:flex-row gap-8 md:gap-12 z-10">
      
      <button @click="closeProductModal" class="absolute top-6 right-6 text-slate-400 hover:text-slate-900 transition bg-gray-100 hover:bg-gray-200 rounded-full p-2 z-20">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
      </button>
      
      <div class="md:w-1/2 aspect-[3/4] rounded-2xl overflow-hidden bg-gray-100 flex-shrink-0 border border-white/50 shadow-sm relative">
        <img :src="selectedProduct?.image" :alt="selectedProduct?.name" class="w-full h-full object-cover">
        <div v-if="selectedProduct?.tag" class="absolute top-4 left-4 bg-[#e3342f] text-white text-xs font-bold px-3 py-1.5 rounded uppercase tracking-wider shadow-sm">
          {{ selectedProduct?.tag }}
        </div>
      </div>
      
      <div class="md:w-1/2 flex flex-col justify-center">
        <span class="text-sm text-[#e3342f] mb-2 uppercase tracking-widest font-black flex items-center gap-2">
          🔥 FLASH SALE ĐANG DIỄN RA
        </span>
        <h3 class="text-3xl font-black text-slate-900 mb-6 uppercase tracking-tighter leading-tight">{{ selectedProduct?.name }}</h3>
        
        <div class="flex items-end gap-3 mb-8">
          <p class="text-3xl font-black text-[#e3342f]">{{ selectedProduct?.price }}</p>
          <p class="text-lg font-medium text-gray-400 line-through pb-1">{{ selectedProduct?.oldPrice }}</p>
        </div>
        
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
              :class="selectedSize === size ? 'bg-[#e3342f] text-white border-[#e3342f] shadow-md' : 'bg-white text-slate-700 border-gray-300 hover:border-[#e3342f]'"
              class="w-12 h-12 rounded-xl border flex items-center justify-center font-medium transition-all duration-200"
            >
              {{ size }}
            </button>
          </div>
        </div>
        
        <div class="flex flex-col gap-4">
          <button @click="handleAddFromModal" class="w-full bg-[#e3342f] text-white font-black py-4 rounded-full shadow-lg hover:bg-red-700 transition duration-300 uppercase tracking-wider">
            CHỐT DEAL NGAY
          </button>
          <button @click="closeProductModal" class="w-full border border-gray-300 text-slate-700 font-medium py-4 rounded-full hover:bg-gray-100 transition duration-300 uppercase tracking-wider text-xs">
            Tiếp tục săn sale
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