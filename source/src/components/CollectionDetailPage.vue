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

const collectionTitle = ref('BỘ SƯU TẬP')
const products = ref([])

// KHO DỮ LIỆU BỘ SƯU TẬP TỔNG
const collectionDatabase = {
  'office': [
    { id: 1, name: 'Set "Thanh Lịch Chốt Đơn": Sơ Mi & Quần Tây', price: '450.000đ', image: '/images/OutfitSection/f2.png', tag: 'OFFICE' },
    { id: 2, name: 'Combo CEO Trẻ: Polo Knit & Khaki Suông', price: '480.000đ', image: '/images/OutfitSection/f3.png', tag: 'BEST' },
    { id: 3, name: 'Set "Họp Báo": Blazer Boxy & Jean Trơn', price: '890.000đ', image: '/images/OutfitSection/f4.png', tag: 'HOT' },
    { id: 4, name: 'Outfit Công Sở Tối Giản (White/Gray)', price: '390.000đ', image: '/images/OutfitSection/f5.png', tag: '' },
    { id: 5, name: 'Set "Đi Làm Thứ 6": Sơ Mi Cuban & Chino', price: '420.000đ', image: '/images/OutfitSection/f6.png', tag: '' },
    { id: 6, name: 'Combo Gilet Layering Kiểu Hàn', price: '510.000đ', image: '/images/OutfitSection/f7.png', tag: 'NEW' },
    { id: 7, name: 'Set "Minimalist CEO": All Black Outfit', price: '550.000đ', image: '/images/OutfitSection/f8.png', tag: '' },
    { id: 8, name: 'Combo Sơ Mi Oxford & Quần Xám Trầm', price: '440.000đ', image: '/images/OutfitSection/f9.png', tag: '' },
    { id: 9, name: 'Set "Smart Casual" Cho Developer', price: '400.000đ', image: '/images/OutfitSection/f10.png', tag: '' },
    { id: 10, name: 'Combo Áo Khoác Nhẹ & Sơ Mi Trắng', price: '590.000đ', image: '/images/OutfitSection/f11.png', tag: '' }
  ],
  'chill': [
    { id: 11, name: 'Combo "Good Morning": Polo Sọc Xanh Form Rộng & Jean Baggy', price: '320.000đ', image: '/images/ChillTeamSection/f2.png', tag: 'CHILL' },
    { id: 12, name: 'Outfit "Bắt Trọn Ánh Nhìn": Cardigan Đỏ Cháy Phố & Quần Suông', price: '350.000đ', image: '/images/ChillTeamSection/f3.png', tag: 'HOT' },
    { id: 13, name: 'Set "Cà Phê Bệt": Thun Basic Xám & Baggy Jean Bụi Bặm', price: '290.000đ', image: '/images/ChillTeamSection/f4.png', tag: 'BEST' },
    { id: 14, name: 'Combo "Lượn Lờ Phố Xá": Sơ Mi Khoác Ngoài & Quần Dù Thụng', price: '410.000đ', image: '/images/ChillTeamSection/f5.png', tag: '' },
    { id: 15, name: 'Outfit "Hẹn Hò Tinh Tế": Layering Sweater Quàng Vai & Quần Tây Kẻ', price: '380.000đ', image: '/images/ChillTeamSection/f6.png', tag: '' },
    { id: 16, name: 'Set "Núp Dưới Mưa": Hoodie Đen Oversize & Jean Wash Sáng Màu', price: '310.000đ', image: '/images/ChillTeamSection/f7.png', tag: 'NEW' },
    { id: 17, name: 'Combo "Trầm Tính": Sweater Xám Layer Tà Áo & Quần Suông Đồng Điệu', price: '270.000đ', image: '/images/ChillTeamSection/f8.png', tag: '' },
    { id: 18, name: 'Outfit "Năng Động Cuối Tuần": Polo Xanh Lá & Short Kaki Ống Rộng', price: '330.000đ', image: '/images/ChillTeamSection/f9.png', tag: '' },
    { id: 19, name: 'Set "Cool Boy Ngầm": Sweater Đen Graphic & Quần Kẻ Sọc Tối Màu', price: '460.000đ', image: '/images/ChillTeamSection/f10.png', tag: 'DREAMY' },
    { id: 20, name: 'Combo "Chàng Trai Ấm Áp": Thun Trắng Trơn, Áo Vắt Vai & Quần Suông', price: '340.000đ', image: '/images/ChillTeamSection/f11.png', tag: '' }
  ],
  'match': [
    { id: 21, name: 'Set "Cozy Boy": Cardigan Lông Màu Gradient & Quần Suông Đen', price: '450.000đ', image: '/images/MatchReadySection/f2.png', tag: 'BASIC' },
    { id: 22, name: 'Outfit "Cháy Phố": Jacket Đỏ Boxy Lửng & Baggy Lả Lướt', price: '520.000đ', image: '/images/MatchReadySection/f3.png', tag: 'HOT' },
    { id: 23, name: 'Combo "Good Boy": Cardigan Len Mỏng & Quần Âu', price: '480.000đ', image: '/images/MatchReadySection/f4.png', tag: '' },
    { id: 24, name: 'Set "Y2K Vibe": Polo Dệt Kim Cộc Tay & Jean Siêu Thụng', price: '750.000đ', image: '/images/MatchReadySection/f5.png', tag: 'TRENDING' },
    { id: 25, name: 'Outfit "Thu Cổ Điển": Suede Jacket Da Lộn Nâu & Quần Suông', price: '320.000đ', image: '/images/MatchReadySection/f6.png', tag: '' },
    { id: 26, name: 'Set "Thư Sinh": Sơ Mi Layer Sáng Màu Phối Áo Xanh Cổ Lọ', price: '390.000đ', image: '/images/MatchReadySection/f7.png', tag: '' },
    { id: 27, name: 'Combo "Dạo Phố Đêm": Áo Dệt Kim Xám Khói & Quần Dù Parachute', price: '410.000đ', image: '/images/MatchReadySection/f8.png', tag: 'NEW' },
    { id: 28, name: 'Outfit "Darkwear": Jacket Cổ Trụ Khóa Cài Kim Loại & Quần Đen', price: '550.000đ', image: '/images/MatchReadySection/f9.png', tag: '' },
    { id: 29, name: 'Set "Quyền Lực Ngầm": Suit Đỏ Rượu Vang Dáng Thụng Sang Trọng', price: '620.000đ', image: '/images/MatchReadySection/f10.png', tag: 'BEST SELLER' },
    { id: 30, name: 'Combo "Tối Giản Sang Trọng": Jacket Cropped Tối Màu & Áo Cổ Lọ Đen', price: '350.000đ', image: '/images/MatchReadySection/f11.png', tag: '' }
  ],
  'relax': [
    { id: 101, name: 'Set "Chữa Lành": Polo Len Nâu Layer Sơ Mi Kẻ & Quần Baggy', price: '420.000đ', image: '/images/WeekendVibesSection/relax/f1.png', tag: 'HOT' },
    { id: 102, name: 'Combo "Ngủ Nướng": Áo Len Cổ Tim Nâu & Quần Tây Ống Rộng', price: '350.000đ', image: '/images/WeekendVibesSection/relax/f2.png', tag: 'NEW' },
    { id: 103, name: 'Outfit "Staycation": Sơ Mi Dệt Kim Xanh Bơ & Jean Đen', price: '480.000đ', image: '/images/WeekendVibesSection/relax/f3.png', tag: '' },
    { id: 104, name: 'Set "Lười Biếng": Jacket Cam Đất Khoác Ngoài & Quần Suông', price: '390.000đ', image: '/images/WeekendVibesSection/relax/f4.png', tag: 'COZY' },
    { id: 105, name: 'Combo "Cafe Sáng Thứ 7": Cardigan Len Navy & Quần Kaki Sáng', price: '310.000đ', image: '/images/WeekendVibesSection/relax/f5.png', tag: '' },
    { id: 106, name: 'Set "Vibe Ngoại Ô": Áo Thun Dài Tay Đỏ Rượu & Quần Kaki Trắng', price: '550.000đ', image: '/images/WeekendVibesSection/relax/f6.png', tag: '' },
    { id: 107, name: 'Combo "Homeboy": Thun Trắng Layer Áo Sọc & Baggy Jean', price: '280.000đ', image: '/images/WeekendVibesSection/relax/f7.png', tag: '' },
    { id: 108, name: 'Outfit "Chilling Cực Mạnh": Áo Nỉ Nâu Wash Bụi & Quần Jorts', price: '340.000đ', image: '/images/WeekendVibesSection/relax/f8.png', tag: 'TRENDING' },
    { id: 109, name: 'Set "Mưa Lạnh": Sweater Nâu Layer Áo Cổ Đỏ & Jean Baggy', price: '460.000đ', image: '/images/WeekendVibesSection/relax/f9.png', tag: '' },
    { id: 110, name: 'Combo "Nghe Nhạc Chill": Layer Thun Xanh Phối Hoodie & Short Nỉ', price: '390.000đ', image: '/images/WeekendVibesSection/relax/f10.png', tag: 'BEST' }
  ],
  'minimal': [
    { id: 201, name: 'Set "Quiet Luxury": Sơ Mi Cổ Trụ Nâu Trầm & Quần Kaki Nâu', price: '450.000đ', image: '/images/WeekendVibesSection/minimal/f1.png', tag: 'CLASSIC' },
    { id: 202, name: 'Combo "Old Money": Áo Dệt Kim Trắng Viền Đen & Quần Chino', price: '520.000đ', image: '/images/WeekendVibesSection/minimal/f2.png', tag: 'LUXURY' },
    { id: 203, name: 'Outfit "Gọn Gàng": Polo Dệt Kim Đen Cộc Tay & Quần Suông Kaki', price: '380.000đ', image: '/images/WeekendVibesSection/minimal/f3.png', tag: '' },
    { id: 204, name: 'Set "Monochrome": Áo Len Cổ Tim Màu Kem & Quần Âu Đen', price: '410.000đ', image: '/images/WeekendVibesSection/minimal/f4.png', tag: 'HOT' },
    { id: 205, name: 'Combo "Vượt Thời Gian": Sơ Mi Kẻ Sọc Xám Phom Rộng & Quần Tây', price: '590.000đ', image: '/images/WeekendVibesSection/minimal/f5.png', tag: '' },
    { id: 206, name: 'Set "Smart Minimal": Jacket Đen Mỏng Phối Sơ Mi Kẻ & Quần Âu', price: '360.000đ', image: '/images/WeekendVibesSection/minimal/f6.png', tag: 'NEW' },
    { id: 207, name: 'Outfit "Basic Not Boring": Áo Thun Đen Boxy & Quần Jean Wash Bụi', price: '350.000đ', image: '/images/WeekendVibesSection/minimal/f7.png', tag: '' },
    { id: 208, name: 'Combo "The Architect": Áo Thun Trơn Màu Hồng Đất & Quần Đen', price: '480.000đ', image: '/images/WeekendVibesSection/minimal/f8.png', tag: 'BEST' },
    { id: 209, name: 'Set "Clean Boy": Áo Thun Nâu Cộc Tay Boxy & Quần Tây Đen', price: '420.000đ', image: '/images/WeekendVibesSection/minimal/f9.png', tag: '' },
    { id: 210, name: 'Outfit "Giao Mùa Tối Giản": Áo Thun Trắng Phom Vừa & Quần Âu Cạp Cao', price: '490.000đ', image: '/images/WeekendVibesSection/minimal/f10.png', tag: '' }
  ],
  'sport': [
    { id: 301, name: 'Set "Gym Rat Lên Phố": Bộ Nỉ Đen Half-Zip & Quần Jogger', price: '250.000đ', image: '/images/WeekendVibesSection/sport/f1.png', tag: 'SPORTY' },
    { id: 302, name: 'Combo "Chạy Bộ Mùa Thu": Set Nỉ Xám Sáng Trơn Tối Giản', price: '480.000đ', image: '/images/WeekendVibesSection/sport/f2.png', tag: 'HOT' },
    { id: 303, name: 'Outfit "Gorpcore Vibe": Set Áo Khoác Hoodie Zip Navy & Quần Nỉ', price: '620.000đ', image: '/images/WeekendVibesSection/sport/f3.png', tag: 'TRENDING' },
    { id: 304, name: 'Set "Cầu Lông Cuối Tuần": Hoodie Đen Phom Rộng Dây Rút & Jogger', price: '290.000đ', image: '/images/WeekendVibesSection/sport/f4.png', tag: '' },
    { id: 305, name: 'Combo "Blokecore Đi Quẩy": Set Nỉ Thể Thao Đỏ Đô Nổi Bật', price: '340.000đ', image: '/images/WeekendVibesSection/sport/f5.png', tag: 'STREET' },
    { id: 306, name: 'Set "Đạp Xe Hồ Tây": Bộ Đồ Nỉ Đen Trơn Basic Cho Mùa Đông', price: '310.000đ', image: '/images/WeekendVibesSection/sport/f6.png', tag: 'NEW' },
    { id: 307, name: 'Outfit "Street Workout": Set Tracksuit Kem Phối Viền Cổ Điển', price: '270.000đ', image: '/images/WeekendVibesSection/sport/f7.png', tag: '' },
    { id: 308, name: 'Combo "Bóng Rổ Đêm": Bộ Nỉ Xám Hoodie Phom Dày Dặn', price: '450.000đ', image: '/images/WeekendVibesSection/sport/f8.png', tag: 'BEST' },
    { id: 309, name: 'Set "Leo Núi Bảnh Bao": Bộ Áo Nỉ Cổ Bẻ Polo Xám & Quần Trơn', price: '580.000đ', image: '/images/WeekendVibesSection/sport/f9.png', tag: '' },
    { id: 310, name: 'Outfit "Runner": Tracksuit Navy Thể Thao Kẻ Sọc Trắng Hai Bên', price: '330.000đ', image: '/images/WeekendVibesSection/sport/f10.png', tag: '' }
  ]
}

// BỘ ĐIỀU KHIỂN MODAL CHỌN SIZE
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

// Thêm nhanh từ card (không mở modal)
const handleQuickAdd = (product, event) => {
  event.stopPropagation()
  addToCart(product, 'L')
  triggerToast(`Đã thêm “${product.name.slice(0, 28)}...” vào giỏ!`)
}

// Thêm từ modal với size đã chọn
const handleAddFromModal = () => {
  if (!selectedProduct.value) return
  addToCart(selectedProduct.value, selectedSize.value)
  triggerToast(`Đã thêm vào giỏ hàng! 🛒`)
  closeProductModal()
}

onMounted(() => {
  const urlParams = new URLSearchParams(window.location.search);
  const type = urlParams.get('type');
  
  if (type && collectionDatabase[type]) {
    products.value = collectionDatabase[type];
    
    if (type === 'office') collectionTitle.value = 'BỘ SƯU TẬP: TEAM CÔNG SỞ'
    else if (type === 'chill') collectionTitle.value = 'BỘ SƯU TẬP: TEAM CHILL'
    else if (type === 'match') collectionTitle.value = 'BỘ SƯU TẬP: PHỐI ĐỒ 3 GIÂY'
    else if (type === 'relax') collectionTitle.value = 'WEEKEND VIBES: TEAM THƯ GIÃN'
    else if (type === 'minimal') collectionTitle.value = 'WEEKEND VIBES: TEAM TỐI GIẢN'
    else if (type === 'sport') collectionTitle.value = 'WEEKEND VIBES: TEAM THỂ THAO'
    
  } else {
    products.value = collectionDatabase['office'];
    collectionTitle.value = 'BỘ SƯU TẬP: TEAM CÔNG SỞ';
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
        <span class="text-sm text-gray-500 mb-2 uppercase tracking-widest">Lookbook Gợi Ý</span>
        <h1 class="text-3xl md:text-4xl font-black text-slate-900 uppercase tracking-tight text-center">
          {{ collectionTitle }}
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
          <option>Bán chạy nhất</option>
          <option>Giá: Thấp đến cao</option>
          <option>Giá: Cao đến thấp</option>
        </select>
      </div>
    </div>

    <section class="max-w-[1400px] mx-auto px-4 md:px-10">
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-6">
        <div v-for="item in products" :key="item.id" @click="openProductModal(item)" class="group cursor-pointer flex flex-col">
          <div class="aspect-[3/4] bg-gray-100 mb-4 overflow-hidden relative rounded-xl shadow-sm border border-black/5">
            <img :src="item.image" :alt="item.name" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
            <div v-if="item.tag" class="absolute top-3 left-3 bg-slate-900 text-white text-[9px] font-bold px-2 py-1.5 rounded uppercase tracking-wider">
              {{ item.tag }}
            </div>
            <div class="absolute bottom-0 left-0 w-full p-3 opacity-0 group-hover:opacity-100 translate-y-4 group-hover:translate-y-0 transition-all duration-300">
              <button @click="handleQuickAdd(item, $event)" class="w-full bg-white/90 backdrop-blur text-slate-900 text-[11px] font-bold py-2.5 rounded-full shadow-lg hover:bg-slate-900 hover:text-white transition">
                THÊM VÀO GIỎ
              </button>
            </div>
          </div>
          <h3 class="text-xs md:text-sm font-medium text-slate-900 line-clamp-2 mb-1 group-hover:text-[#705847] transition">{{ item.name }}</h3>
          <p class="text-slate-700 text-sm md:text-base font-bold mt-auto">{{ item.price }}</p>
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
        <span class="text-sm text-[#705847] mb-2 uppercase tracking-widest font-light">Lookbook Outfit</span>
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
.toast-enter-active { animation: toastIn 0.35s cubic-bezier(0.34, 1.56, 0.64, 1); }
.toast-leave-active { transition: all 0.25s ease; }
.toast-leave-to { transform: translateX(-50%) translateY(20px); opacity: 0; }
@keyframes toastIn {
  from { transform: translateX(-50%) translateY(20px); opacity: 0; }
  to   { transform: translateX(-50%) translateY(0);    opacity: 1; }
}
</style>