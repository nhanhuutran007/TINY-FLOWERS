<script setup>
import { ref, computed, onMounted, onUnmounted, nextTick } from 'vue'
import { useCart } from '../composables/useCart.js'

const emit = defineEmits(['close'])
const { addToCart } = useCart()
const searchQuery = ref('')
const searchInput = ref(null)

// ─── KHO SẢN PHẨM TOÀN BỘ WEB ────────────────────────────────────────────────
const allProducts = [
  // ── Sale Page: Áo Khoác ──
  { id: 'j1', name: 'Áo Khoác Dù Parachute Bụi Bặm', price: '193.000đ', image: '/images/SalePage/j1.png', category: 'Áo Khoác', tag: 'FLASH SALE' },
  { id: 'j2', name: 'Áo Khoác Gió Form Boxy Phối Trắng', price: '210.000đ', image: '/images/SalePage/j2.png', category: 'Áo Khoác', tag: '-40%' },
  { id: 'j3', name: 'Áo Khoác Chống Nắng UV Phom Rộng', price: '185.000đ', image: '/images/SalePage/j3.png', category: 'Áo Khoác', tag: 'FLASH SALE' },
  { id: 'j4', name: 'Áo Khoác Nhẹ Cổ Đứng Minimal', price: '220.000đ', image: '/images/SalePage/j4.png', category: 'Áo Khoác', tag: '-30%' },
  { id: 'j5', name: 'Áo Khoác Denim Đen Wash Rách', price: '250.000đ', image: '/images/SalePage/j5.png', category: 'Áo Khoác', tag: 'FLASH SALE' },
  { id: 'j6', name: 'Áo Khoác Bomber Da PU Cao Cấp', price: '320.000đ', image: '/images/SalePage/j6.png', category: 'Áo Khoác', tag: '-50%' },
  { id: 'j7', name: 'Áo Khoác Nỉ Form Thụng Varsity', price: '199.000đ', image: '/images/SalePage/j7.png', category: 'Áo Khoác', tag: '-40%' },
  { id: 'j8', name: 'Jacket Kaki Mỏng Mùa Thu Nhẹ Nhàng', price: '215.000đ', image: '/images/SalePage/j8.png', category: 'Áo Khoác', tag: 'FLASH SALE' },
  // ── Sale Page: Áo Thun ──
  { id: 't1', name: 'Áo Thun Cotton Mát Lạnh Thoáng Khí', price: '99.000đ', image: '/images/SalePage/t1.png', category: 'Áo Thun', tag: 'DEAL SỐC' },
  { id: 't2', name: 'Áo Baby Tee Thêu Logo Nổi Bật', price: '120.000đ', image: '/images/SalePage/t2.png', category: 'Áo Thun', tag: '-40%' },
  { id: 't3', name: 'Áo Thun Drop Shoulder Dáng Thụng', price: '149.000đ', image: '/images/SalePage/t3.png', category: 'Áo Thun', tag: 'HOT' },
  { id: 't4', name: 'Áo Thun Wash Bụi Phong Cách Đường Phố', price: '169.000đ', image: '/images/SalePage/t4.png', category: 'Áo Thun', tag: '-50%' },
  { id: 't5', name: 'Polo Zip Vải Mắt Chim Hút Mồ Hôi', price: '155.000đ', image: '/images/SalePage/t5.png', category: 'Áo Polo', tag: 'FLASH SALE' },
  { id: 't6', name: 'Áo Thun Graphic In Nổi Y2K', price: '135.000đ', image: '/images/SalePage/t6.png', category: 'Áo Thun', tag: '-30%' },
  { id: 't7', name: 'Tank Top Thể Thao Siêu Nhẹ', price: '89.000đ', image: '/images/SalePage/t7.png', category: 'Tank Top', tag: 'DEAL SỐC' },
  { id: 't8', name: 'Áo Thun Trơn Basic Dễ Phối Đồ', price: '110.000đ', image: '/images/SalePage/t8.png', category: 'Áo Thun', tag: '-40%' },
  // ── Form F1: Oversized ──
  { id: 'f101', name: 'Áo Cardigan Oversize Wash Bụi', price: '350.000đ', image: '/images/Products/F1/1.png', category: 'Form Oversized', tag: 'NEW' },
  { id: 'f102', name: 'Hoodie Khổng Lồ Zip Local Brand', price: '420.000đ', image: '/images/Products/F1/2.png', category: 'Form Oversized', tag: 'BEST SELLER' },
  { id: 'f103', name: 'Quần Hộp Oversize Trượt Ván', price: '290.000đ', image: '/images/Products/F1/3.png', category: 'Quần', tag: '' },
  { id: 'f104', name: 'Áo Len Thủng Oversize Y2K', price: '350.000đ', image: '/images/Products/F1/4.png', category: 'Form Oversized', tag: 'HOT' },
  { id: 'f105', name: 'Sơ Mi Flannel Kẻ Caro Form Rộng', price: '280.000đ', image: '/images/Products/F1/5.png', category: 'Áo Sơ Mi', tag: '' },
  { id: 'f106', name: 'Quần Tây Oversize', price: '380.000đ', image: '/images/Products/F1/6.png', category: 'Quần', tag: '' },
  { id: 'f107', name: 'Áo Bóng Rổ Layer Phom Rộng', price: '210.000đ', image: '/images/Products/F1/7.png', category: 'Form Oversized', tag: 'TRENDING' },
  { id: 'f108', name: 'Quần Jean Rách Gối Siêu Thụng', price: '390.000đ', image: '/images/Products/F1/8.png', category: 'Quần Jean', tag: '' },
  // ── Form F2: Baggy ──
  { id: 'f201', name: 'Quần Jean Baggy Cào Xước', price: '350.000đ', image: '/images/Products/F2/1.png', category: 'Quần Jean', tag: 'HOT' },
  { id: 'f202', name: 'Quần Kaki Baggy Túi Hộp Lớn', price: '320.000đ', image: '/images/Products/F2/2.png', category: 'Quần', tag: '' },
  { id: 'f203', name: 'Quần Đùi Baggy Jean Jorts', price: '280.000đ', image: '/images/Products/F2/3.png', category: 'Quần Jean', tag: 'TRENDING' },
  { id: 'f204', name: 'Sơ Mi Denim Dáng Baggy', price: '310.000đ', image: '/images/Products/F2/4.png', category: 'Áo Sơ Mi', tag: '' },
  { id: 'f205', name: 'Áo Thun Rộng Phối Tay Đôi', price: '190.000đ', image: '/images/Products/F2/5.png', category: 'Áo Thun', tag: '' },
  { id: 'f206', name: 'Quần Nhung Tăm Corduroy Baggy', price: '340.000đ', image: '/images/Products/F2/6.png', category: 'Quần', tag: 'NEW' },
  { id: 'f207', name: 'Quần Dù Parachute Xếp Ly Gối', price: '360.000đ', image: '/images/Products/F2/7.png', category: 'Quần', tag: '' },
  { id: 'f208', name: 'Áo Khoác Kaki Bụi Bặm Dáng Thụng', price: '450.000đ', image: '/images/Products/F2/8.png', category: 'Áo Khoác', tag: 'BEST SELLER' },
  // ── Form F3: Relaxed ──
  { id: 'f301', name: 'Quần Tây Straight Leg Khóa Zip', price: '380.000đ', image: '/images/Products/F3/1.png', category: 'Quần', tag: 'OFFICE CORE' },
  { id: 'f302', name: 'Sơ Mi Cổ Vest Dáng Relaxed', price: '250.000đ', image: '/images/Products/F3/2.png', category: 'Áo Sơ Mi', tag: '' },
  { id: 'f303', name: 'Quần Jean Ống Suông Trơn Đen', price: '330.000đ', image: '/images/Products/F3/3.png', category: 'Quần Jean', tag: 'BEST SELLER' },
  { id: 'f304', name: 'Áo Polo Vải Knit Dệt Kim', price: '290.000đ', image: '/images/Products/F3/4.png', category: 'Áo Polo', tag: '' },
  { id: 'f305', name: 'Cardigan Mỏng Dáng Suông', price: '310.000đ', image: '/images/Products/F3/5.png', category: 'Áo Khoác', tag: '' },
  { id: 'f306', name: 'Áo Khoác Nhẹ Dáng Straight', price: '450.000đ', image: '/images/Products/F3/6.png', category: 'Áo Khoác', tag: '' },
  { id: 'f307', name: 'Áo Thun Dài Tay Suông Trơn', price: '180.000đ', image: '/images/Products/F3/7.png', category: 'Áo Thun', tag: 'BASIC' },
  { id: 'f308', name: 'Quần Chino Vải Lanh Mềm Mại', price: '310.000đ', image: '/images/Products/F3/8.png', category: 'Quần', tag: 'NEW' },
  // ── Form F4: Cropped Boxy ──
  { id: 'f401', name: 'Jacket Da Lửng Cropped Biker', price: '550.000đ', image: '/images/Products/F4/1.png', category: 'Áo Khoác', tag: 'LUXURY' },
  { id: 'f402', name: 'Baby Tee Nam In Typo', price: '190.000đ', image: '/images/Products/F4/2.png', category: 'Áo Thun', tag: 'HOT' },
  { id: 'f403', name: 'Sơ Mi Cộc Tay Cropped Boxy', price: '240.000đ', image: '/images/Products/F4/3.png', category: 'Áo Sơ Mi', tag: '' },
  { id: 'f404', name: 'Áo Khoác Bomber Varsity Dáng Lửng', price: '480.000đ', image: '/images/Products/F4/4.png', category: 'Áo Khoác', tag: 'NEW' },
  { id: 'f405', name: 'Áo Thun Dáng Hộp Cắt Gấu', price: '180.000đ', image: '/images/Products/F4/5.png', category: 'Áo Thun', tag: '' },
  { id: 'f406', name: 'Áo Cardigan Cổ V Cropped', price: '320.000đ', image: '/images/Products/F4/6.png', category: 'Áo Khoác', tag: '' },
  { id: 'f407', name: 'Áo Len Móc Crochet Xuyên Thấu', price: '290.000đ', image: '/images/Products/F4/7.png', category: 'Áo Len', tag: 'TRENDING' },
  { id: 'f408', name: 'Áo Khoác Jean Lửng Frayed Hem', price: '420.000đ', image: '/images/Products/F4/8.png', category: 'Áo Khoác', tag: '' },
  // ── Form F5: Boxy ──
  { id: 'f501', name: 'Áo Thun Phom Boxy Trơn', price: '210.000đ', image: '/images/Products/F5/1.png', category: 'Áo Thun', tag: 'ESSENTIAL' },
  { id: 'f502', name: 'Sơ Mi Nhung Tăm Boxy Khoác Ngoài', price: '280.000đ', image: '/images/Products/F5/2.png', category: 'Áo Sơ Mi', tag: '' },
  { id: 'f503', name: 'Jacket Kaki Boxy Zip Hai Chiều', price: '410.000đ', image: '/images/Products/F5/3.png', category: 'Áo Khoác', tag: 'BEST SELLER' },
  { id: 'f504', name: 'Polo Dài Tay Cổ Bẻ Dáng Boxy', price: '260.000đ', image: '/images/Products/F5/4.png', category: 'Áo Polo', tag: '' },
  { id: 'f505', name: 'Sweater Nỉ Cổ Tròn Dáng Hộp', price: '320.000đ', image: '/images/Products/F5/5.png', category: 'Áo Len', tag: '' },
  { id: 'f506', name: 'Áo Khoác Denim Boxy Nút Bấm', price: '460.000đ', image: '/images/Products/F5/6.png', category: 'Áo Khoác', tag: 'HOT' },
  { id: 'f507', name: 'Áo Gilet Chần Bông Phom Boxy', price: '350.000đ', image: '/images/Products/F5/7.png', category: 'Áo Khoác', tag: 'NEW' },
  { id: 'f508', name: 'Sơ Mi Nhăn Crinkle Dáng Hộp', price: '240.000đ', image: '/images/Products/F5/8.png', category: 'Áo Sơ Mi', tag: '' },
  // ── Bộ Sưu Tập: Office ──
  { id: 'c1', name: 'Set Thanh Lịch Chốt Đơn: Sơ Mi & Quần Tây', price: '450.000đ', image: '/images/OutfitSection/f2.png', category: 'Set Outfit', tag: 'OFFICE' },
  { id: 'c2', name: 'Combo CEO Trẻ: Polo Knit & Khaki Suông', price: '480.000đ', image: '/images/OutfitSection/f3.png', category: 'Set Outfit', tag: 'BEST' },
  { id: 'c3', name: 'Set Họp Báo: Blazer Boxy & Jean Trơn', price: '890.000đ', image: '/images/OutfitSection/f4.png', category: 'Set Outfit', tag: 'HOT' },
  { id: 'c4', name: 'Outfit Công Sở Tối Giản White/Gray', price: '390.000đ', image: '/images/OutfitSection/f5.png', category: 'Set Outfit', tag: '' },
  { id: 'c5', name: 'Combo Gilet Layering Kiểu Hàn', price: '510.000đ', image: '/images/OutfitSection/f7.png', category: 'Set Outfit', tag: 'NEW' },
  // ── Bộ Sưu Tập: Chill ──
  { id: 'ch1', name: 'Combo Good Morning: Polo Sọc & Jean Baggy', price: '320.000đ', image: '/images/ChillTeamSection/f2.png', category: 'Set Outfit', tag: 'CHILL' },
  { id: 'ch2', name: 'Set Cà Phê Bệt: Thun Basic & Baggy Jean', price: '290.000đ', image: '/images/ChillTeamSection/f4.png', category: 'Set Outfit', tag: 'BEST' },
  { id: 'ch3', name: 'Set Núp Dưới Mưa: Hoodie Đen & Jean Wash', price: '310.000đ', image: '/images/ChillTeamSection/f7.png', category: 'Set Outfit', tag: 'NEW' },
  // ── Bộ Sưu Tập: Weekend ──
  { id: 'w1', name: 'Set Chữa Lành: Polo Len Nâu & Quần Baggy', price: '420.000đ', image: '/images/WeekendVibesSection/relax/f1.png', category: 'Set Outfit', tag: 'HOT' },
  { id: 'w2', name: 'Set Quiet Luxury: Sơ Mi Nâu Trầm & Kaki', price: '450.000đ', image: '/images/WeekendVibesSection/minimal/f1.png', category: 'Set Outfit', tag: 'CLASSIC' },
  { id: 'w3', name: 'Set Gym Rat: Bộ Nỉ Đen & Quần Jogger', price: '250.000đ', image: '/images/WeekendVibesSection/sport/f1.png', category: 'Set Thể Thao', tag: 'SPORTY' },
  { id: 'w4', name: 'Outfit Gorpcore: Hoodie Zip Navy & Nỉ', price: '620.000đ', image: '/images/WeekendVibesSection/sport/f3.png', category: 'Set Thể Thao', tag: 'TRENDING' },
]

const hotKeywords = ['Áo thun oversize', 'Quần baggy', 'Áo khoác bomber', 'Polo Y2K', 'Tank top', 'Quần dù cargo', 'Sơ mi', 'Set outfit']

const popularCategories = [
  { name: 'Áo Thun', icon: '👕' },
  { name: 'Áo Khoác', icon: '🧥' },
  { name: 'Quần Jean', icon: '👖' },
  { name: 'Set Outfit', icon: '🎽' },
  { name: 'Áo Sơ Mi', icon: '👔' },
  { name: 'Áo Polo', icon: '🎪' },
]

// ─── CHUẨN HÓA TIẾNG VIỆT (xóa dấu để tìm không phân biệt dấu) ──────────────
const normalize = (str) =>
  str.normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/đ/g, 'd').replace(/Đ/g, 'D').toLowerCase().trim()

// ─── TÌM KIẾM REAL-TIME ───────────────────────────────────────────────────────
const searchResults = computed(() => {
  if (!searchQuery.value.trim()) return []
  const q = normalize(searchQuery.value)
  return allProducts.filter(p =>
    normalize(p.name).includes(q) ||
    normalize(p.category).includes(q) ||
    (p.tag && normalize(p.tag).includes(q))
  ).slice(0, 8)
})

// ─── THÊM VÀO GIỎ TỪ KẾT QUẢ TÌM KIẾM ──────────────────────────────────────
const addedId = ref(null)

const handleAddToCart = (product, event) => {
  event.stopPropagation()
  addToCart(product, 'L')
  addedId.value = product.id
  setTimeout(() => { addedId.value = null }, 1500)
}

// ─── XỬ LÝ BÀN PHÍM & FOCUS ──────────────────────────────────────────────────
const handleKeydown = (e) => {
  if (e.key === 'Escape') emit('close')
}

const setKeyword = (kw) => {
  searchQuery.value = kw
  searchInput.value?.focus()
}

onMounted(async () => {
  window.addEventListener('keydown', handleKeydown)
  await nextTick()
  searchInput.value?.focus()
})

onUnmounted(() => {
  window.removeEventListener('keydown', handleKeydown)
})
</script>

<template>
  <!-- Overlay -->
  <div class="fixed inset-0 z-[200] flex flex-col" @click.self="$emit('close')">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="$emit('close')"></div>

    <!-- Search Panel -->
    <div class="relative bg-white shadow-2xl animate-slideDown">
      <div class="max-w-[900px] mx-auto px-6 py-8">

        <!-- Search Input -->
        <div class="flex items-center gap-4 border-2 border-slate-900 rounded-2xl px-5 py-4 bg-white shadow-inner">
          <svg viewBox="0 0 24 24" class="w-6 h-6 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="7"></circle><path d="M21 21l-4.35-4.35"></path>
          </svg>
          <input
            ref="searchInput"
            v-model="searchQuery"
            type="text"
            placeholder="Tìm kiếm sản phẩm, phong cách, bộ sưu tập..."
            class="flex-1 bg-transparent outline-none text-slate-900 text-base font-medium placeholder-gray-400"
          />
          <span v-if="searchQuery" class="text-xs text-gray-400 font-medium whitespace-nowrap">
            {{ searchResults.length }} kết quả
          </span>
          <button v-if="searchQuery" @click="searchQuery = ''" class="text-gray-400 hover:text-slate-900 transition">
            <svg viewBox="0 0 24 24" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
          <button @click="$emit('close')" class="ml-1 text-gray-400 hover:text-slate-900 transition font-semibold text-sm border border-gray-200 rounded-lg px-3 py-1">
            ESC
          </button>
        </div>

        <!-- Search Results -->
        <div v-if="searchQuery && searchResults.length > 0" class="mt-6">
          <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">
            Kết Quả Tìm Kiếm — {{ searchResults.length }} sản phẩm
          </p>
          <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            <div
              v-for="product in searchResults"
              :key="product.id"
              class="flex items-center gap-3 p-3 rounded-xl hover:bg-[#f8f4f0] cursor-pointer transition group border border-transparent hover:border-gray-200 relative"
            >
              <!-- Product image -->
              <div class="w-14 h-16 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
                <img :src="product.image" :alt="product.name" class="w-full h-full object-cover group-hover:scale-105 transition duration-300" />
              </div>

              <!-- Info -->
              <div class="flex-1 min-w-0">
                <p class="text-[11px] font-semibold text-slate-900 line-clamp-2 leading-snug">{{ product.name }}</p>
                <span v-if="product.tag" class="inline-block text-[9px] font-bold bg-[#e3342f] text-white px-1.5 py-0.5 rounded mt-0.5 uppercase">{{ product.tag }}</span>
                <p class="text-xs text-[#e3342f] font-black mt-0.5">{{ product.price }}</p>
              </div>

              <!-- Quick-add button -->
              <button
                @click="handleAddToCart(product, $event)"
                :class="addedId === product.id ? 'bg-green-500 text-white' : 'bg-slate-900 text-white hover:bg-slate-700'"
                class="absolute top-2 right-2 w-6 h-6 rounded-full flex items-center justify-center transition opacity-0 group-hover:opacity-100 flex-shrink-0"
                :title="addedId === product.id ? 'Đã thêm!' : 'Thêm vào giỏ'"
              >
                <svg v-if="addedId !== product.id" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                <svg v-else class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
              </button>
            </div>
          </div>
        </div>

        <!-- No Results -->
        <div v-else-if="searchQuery && searchResults.length === 0" class="mt-6 text-center py-8">
          <div class="text-4xl mb-3">🔍</div>
          <p class="text-gray-500 text-sm">Không tìm thấy kết quả cho "<span class="text-slate-900 font-semibold">{{ searchQuery }}</span>"</p>
          <p class="text-gray-400 text-xs mt-1 mb-4">Hãy thử từ khóa khác hoặc chọn danh mục bên dưới</p>
          <div class="flex flex-wrap justify-center gap-2 mt-3">
            <button
              v-for="kw in hotKeywords.slice(0, 4)"
              :key="kw"
              @click="setKeyword(kw)"
              class="px-4 py-1.5 rounded-full bg-[#f8f4f0] text-slate-700 text-xs font-semibold hover:bg-slate-900 hover:text-white transition border border-gray-200"
            >
              {{ kw }}
            </button>
          </div>
        </div>

        <!-- Default State: Hot keywords + Categories -->
        <div v-else class="mt-6 flex flex-col md:flex-row gap-8">
          <!-- Hot Keywords -->
          <div class="flex-1">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">🔥 Từ Khóa Thịnh Hành</p>
            <div class="flex flex-wrap gap-2">
              <button
                v-for="kw in hotKeywords"
                :key="kw"
                @click="setKeyword(kw)"
                class="px-4 py-2 rounded-full bg-[#f8f4f0] text-slate-700 text-xs font-semibold hover:bg-slate-900 hover:text-white transition border border-gray-200 hover:border-slate-900"
              >
                {{ kw }}
              </button>
            </div>

            <!-- Stats -->
            <div class="mt-6 flex items-center gap-3 text-xs text-gray-400">
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
              <span>Tìm kiếm trong <strong class="text-slate-700">{{ allProducts.length }}+</strong> sản phẩm trên toàn bộ cửa hàng</span>
            </div>
          </div>

          <!-- Popular Categories -->
          <div class="md:w-64">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">📦 Danh Mục Phổ Biến</p>
            <div class="grid grid-cols-2 gap-2">
              <button
                v-for="cat in popularCategories"
                :key="cat.name"
                @click="setKeyword(cat.name)"
                class="flex items-center gap-2 px-3 py-2.5 rounded-xl bg-[#f8f4f0] hover:bg-slate-900 hover:text-white text-slate-700 text-xs font-semibold transition text-left border border-transparent hover:border-slate-900"
              >
                <span>{{ cat.icon }}</span>
                <span>{{ cat.name }}</span>
              </button>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<style scoped>
@keyframes slideDown {
  from { transform: translateY(-20px); opacity: 0; }
  to { transform: translateY(0); opacity: 1; }
}
.animate-slideDown {
  animation: slideDown 0.25s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
</style>
