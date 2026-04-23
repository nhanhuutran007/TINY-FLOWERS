<script setup>
import { ref, onMounted } from 'vue'
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

const currentFormId = ref('')
const pageTitle = ref('TẤT CẢ SẢN PHẨM')
const products = ref([])

// 1. KHO DỮ LIỆU
const productDatabase = {
  'F1': [
    { id: 101, name: 'Áo Cardigan Oversize Wash Bụi', price: '350.000đ', image: '/images/Products/F1/1.png', tag: 'NEW' },
    { id: 102, name: 'Hoodie Khổng Lồ Zip Local Brand', price: '420.000đ', image: '/images/Products/F1/2.png', tag: 'BEST SELLER' },
    { id: 103, name: 'Quần Hộp Oversize Trượt Ván', price: '290.000đ', image: '/images/Products/F1/3.png', tag: '' },
    { id: 104, name: 'Áo Len Thủng Oversize Y2K', price: '350.000đ', image: '/images/Products/F1/4.png', tag: 'HOT' },
    { id: 105, name: 'Sơ Mi Flannel Kẻ Caro Form Rộng', price: '280.000đ', image: '/images/Products/F1/5.png', tag: '' },
    { id: 106, name: 'Quần Tây Oversize', price: '380.000đ', image: '/images/Products/F1/6.png', tag: '' },
    { id: 107, name: 'Áo Bóng Rổ Layer Phom Rộng', price: '210.000đ', image: '/images/Products/F1/7.png', tag: 'TRENDING' },
    { id: 108, name: 'Quần Jean Rách Gối Siêu Thụng', price: '390.000đ', image: '/images/Products/F1/8.png', tag: '' }
  ],
  'F2': [
    { id: 201, name: 'Quần Jean Baggy Cào Xước', price: '350.000đ', image: '/images/Products/F2/1.png', tag: 'HOT' },
    { id: 202, name: 'Quần Kaki Baggy Túi Hộp Lớn', price: '320.000đ', image: '/images/Products/F2/2.png', tag: '' },
    { id: 203, name: 'Quần Đùi Baggy Jean Jorts', price: '280.000đ', image: '/images/Products/F2/3.png', tag: 'TRENDING' },
    { id: 204, name: 'Sơ Mi Denim Dáng Baggy', price: '310.000đ', image: '/images/Products/F2/4.png', tag: '' },
    { id: 205, name: 'Áo Thun Rộng Phối Tay Đôi', price: '190.000đ', image: '/images/Products/F2/5.png', tag: '' },
    { id: 206, name: 'Quần Nhung Tăm (Corduroy) Baggy', price: '340.000đ', image: '/images/Products/F2/6.png', tag: 'NEW' },
    { id: 207, name: 'Quần Dù Parachute Xếp Ly Gối', price: '360.000đ', image: '/images/Products/F2/7.png', tag: '' },
    { id: 208, name: 'Áo Khoác Kaki Bụi Bặm Dáng Thụng', price: '450.000đ', image: '/images/Products/F2/8.png', tag: 'BEST SELLER' }
  ],
  'F3': [
    { id: 301, name: 'Quần Tây Straight Leg Khóa Zip', price: '380.000đ', image: '/images/Products/F3/1.png', tag: 'OFFICE CORE' },
    { id: 302, name: 'Sơ Mi Cổ Vest Dáng Relaxed', price: '250.000đ', image: '/images/Products/F3/2.png', tag: '' },
    { id: 303, name: 'Quần Jean Ống Suông Trơn Đen', price: '330.000đ', image: '/images/Products/F3/3.png', tag: 'BEST SELLER' },
    { id: 304, name: 'Áo Polo Vải Knit (Dệt Kim)', price: '290.000đ', image: '/images/Products/F3/4.png', tag: '' },
    { id: 305, name: 'Cardigan Mỏng Dáng Suông', price: '310.000đ', image: '/images/Products/F3/5.png', tag: '' },
    { id: 306, name: 'Áo Khoác Nhẹ Dáng Straight', price: '450.000đ', image: '/images/Products/F3/6.png', tag: '' },
    { id: 307, name: 'Áo Thun Dài Tay Suông Trơn', price: '180.000đ', image: '/images/Products/F3/7.png', tag: 'BASIC' },
    { id: 308, name: 'Quần Chino Vải Lanh Mềm Mại', price: '310.000đ', image: '/images/Products/F3/8.png', tag: 'NEW' }
  ],
  'F4': [
    { id: 401, name: 'Jacket Da Lửng (Cropped Biker)', price: '550.000đ', image: '/images/Products/F4/1.png', tag: 'LUXURY' },
    { id: 402, name: 'Baby Tee Nam In Typo', price: '190.000đ', image: '/images/Products/F4/2.png', tag: 'HOT' },
    { id: 403, name: 'Sơ Mi Cộc Tay Cropped Boxy', price: '240.000đ', image: '/images/Products/F4/3.png', tag: '' },
    { id: 404, name: 'Áo Khoác Bomber Varsity Dáng Lửng', price: '480.000đ', image: '/images/Products/F4/4.png', tag: 'NEW' },
    { id: 405, name: 'Áo Thun Dáng Hộp Cắt Gấu', price: '180.000đ', image: '/images/Products/F4/5.png', tag: '' },
    { id: 406, name: 'Áo Cardigan Cổ V Cropped', price: '320.000đ', image: '/images/Products/F4/6.png', tag: '' },
    { id: 407, name: 'Áo Len Móc Crochet Xuyên Thấu', price: '290.000đ', image: '/images/Products/F4/7.png', tag: 'TRENDING' },
    { id: 408, name: 'Áo Khoác Jean Lửng Frayed Hem', price: '420.000đ', image: '/images/Products/F4/8.png', tag: '' }
  ],
  'F5': [
    { id: 501, name: 'Áo Thun Phom Boxy Trơn', price: '210.000đ', image: '/images/Products/F5/1.png', tag: 'ESSENTIAL' },
    { id: 502, name: 'Sơ Mi Nhung Tăm Boxy Khoác Ngoài', price: '280.000đ', image: '/images/Products/F5/2.png', tag: '' },
    { id: 503, name: 'Jacket Kaki Boxy Zip Hai Chiều', price: '410.000đ', image: '/images/Products/F5/3.png', tag: 'BEST SELLER' },
    { id: 504, name: 'Polo Dài Tay Cổ Bẻ Dáng Boxy', price: '260.000đ', image: '/images/Products/F5/4.png', tag: '' },
    { id: 505, name: 'Sweater Nỉ Cổ Tròn Dáng Hộp', price: '320.000đ', image: '/images/Products/F5/5.png', tag: '' },
    { id: 506, name: 'Áo Khoác Denim Boxy Nút Bấm', price: '460.000đ', image: '/images/Products/F5/6.png', tag: 'HOT' },
    { id: 507, name: 'Áo Gilet Chần Bông Phom Boxy', price: '350.000đ', image: '/images/Products/F5/7.png', tag: 'NEW' },
    { id: 508, name: 'Sơ Mi Nhăn (Crinkle) Dáng Hộp', price: '240.000đ', image: '/images/Products/F5/8.png', tag: '' }
  ]
}

// 2. BỘ ĐIỀU KHIỂN MODAL CHỌN SIZE
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

// Them nhanh tu card
const handleQuickAdd = (product, event) => {
  event.stopPropagation()
  addToCart(product, 'L')
  triggerToast(`Da them "${product.name.slice(0, 28)}..." vao gio!`)
}

// Them tu modal voi size da chon
const handleAddFromModal = () => {
  if (!selectedProduct.value) return
  addToCart(selectedProduct.value, selectedSize.value)
  triggerToast('Da them vao gio hang!')
  closeProductModal()
}

onMounted(() => {
  const urlParams = new URLSearchParams(window.location.search);
  const id = urlParams.get('id');
  
  if (id && productDatabase[id]) { 
    currentFormId.value = id;
    products.value = productDatabase[id];

    if (id === 'F1') pageTitle.value = 'BỘ SƯU TẬP: FORM OVERSIZED'
    if (id === 'F2') pageTitle.value = 'BỘ SƯU TẬP: FORM BAGGY'
    if (id === 'F3') pageTitle.value = 'BỘ SƯU TẬP: FORM RELAXED STRAIGHT'
    if (id === 'F4') pageTitle.value = 'BỘ SƯU TẬP: FORM CROPPED BOXY'
    if (id === 'F5') pageTitle.value = 'BỘ SƯU TẬP: FORM BOXY'
  } else {
    products.value = productDatabase['F1'];
  }
})
</script>

<template>
  <div class="w-full bg-white pb-20 pt-10">

    <!-- Toast -->
    <Teleport to="body">
      <Transition name="toast">
        <div v-if="showToast" class="fixed bottom-6 left-1/2 -translate-x-1/2 z-[500] bg-slate-900 text-white text-sm font-semibold px-6 py-3.5 rounded-full shadow-2xl flex items-center gap-3 whitespace-nowrap">
          <svg class="w-4 h-4 text-green-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
          {{ toastMsg }}
        </div>
      </Transition>
    </Teleport>

    
    <div class="max-w-[1400px] mx-auto px-4 md:px-10 mb-12">
      <div class="flex flex-col items-center border-b border-gray-200 pb-8">
        <span class="text-sm text-gray-500 mb-2 uppercase tracking-widest">Danh mục sản phẩm</span>
        <h1 class="text-3xl md:text-4xl font-black text-slate-900 uppercase tracking-tight text-center">
          {{ pageTitle }}
        </h1>
      </div>
    </div>

    <div class="max-w-[1400px] mx-auto px-4 md:px-10 mb-8 flex justify-between items-center text-sm text-gray-600">
      <div class="flex gap-4">
        <button class="hover:text-black font-medium transition flex items-center gap-2">Bộ lọc ⚙️</button>
      </div>
      <div class="flex gap-4">
        <span>Sắp xếp theo:</span>
        <select class="outline-none font-medium text-black bg-transparent border-b border-gray-300 pb-1 cursor-pointer">
          <option>Mới nhất</option>
          <option>Giá: Thấp đến cao</option>
          <option>Giá: Cao đến thấp</option>
        </select>
      </div>
    </div>

    <section class="max-w-[1400px] mx-auto px-4 md:px-10">
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-8">
        
        <div v-for="item in products" :key="item.id" @click="openProductModal(item)" class="group cursor-pointer flex flex-col">
          <div class="aspect-[3/4] bg-gray-100 mb-4 overflow-hidden relative rounded-xl shadow-sm border border-black/5">
            <img :src="item.image" :alt="item.name" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
            
            <div v-if="item.tag" class="absolute top-3 left-3 bg-slate-900 text-white text-[10px] font-bold px-3 py-1.5 rounded uppercase tracking-wider">
              {{ item.tag }}
            </div>
            
            <div class="absolute bottom-0 left-0 w-full p-4 opacity-0 group-hover:opacity-100 translate-y-4 group-hover:translate-y-0 transition-all duration-300">
              <button @click="handleQuickAdd(item, $event)" class="w-full bg-white/90 backdrop-blur text-slate-900 text-xs font-bold py-3 rounded-full shadow-lg hover:bg-slate-900 hover:text-white transition">
                THÊM VÀO GIỎ
              </button>
            </div>
          </div>
          
          <h3 class="text-sm font-medium text-slate-900 line-clamp-2 mb-1 group-hover:text-[#705847] transition">{{ item.name }}</h3>
          <p class="text-slate-700 font-bold mt-auto">{{ item.price }}</p>
        </div>

      </div>
    </section>

  </div>

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
        <span class="text-sm text-[#705847] mb-2 uppercase tracking-widest font-light">Sản Phẩm Chi Tiết</span>
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
            Tiếp tục mua sắm
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