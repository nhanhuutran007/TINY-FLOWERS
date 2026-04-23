<script setup>
import { ref } from 'vue'

// Hàm chuyển trang sang Bộ sưu tập Đi Làm khi bấm vào banner lớn
const goToOfficeCollection = () => {
  window.location.href = '/collection?type=office'
}

// 1. CHUYỂN ĐỔI DỮ LIỆU THÀNH MẢNG SẢN PHẨM CHI TIẾT
const outfitProducts = ref([
  { id: 2, name: 'Sơ Mi Minimalist CEO & Quần Tây Âu', price: '450.000đ', image: '/images/OutfitSection/f2.png' },
  { id: 3, name: 'Set Smart Casual: Polo Knit & Khaki', price: '480.000đ', image: '/images/OutfitSection/f3.png' },
  { id: 4, name: 'Combo Vest Boxy Hàn Quốc', price: '890.000đ', image: '/images/OutfitSection/f4.png' },
  { id: 5, name: 'Outfit Công Sở Tối Giản (White/Gray)', price: '390.000đ', image: '/images/OutfitSection/f5.png' },
  { id: 6, name: 'Set "Đi Làm Thứ 6": Sơ Mi Cuban & Chino', price: '420.000đ', image: '/images/OutfitSection/f6.png' },
  { id: 7, name: 'Combo Gilet Layering Phối Sơ Mi', price: '510.000đ', image: '/images/OutfitSection/f7.png' },
  { id: 8, name: 'Set Minimalist CEO: All Black Outfit', price: '550.000đ', image: '/images/OutfitSection/f8.png' },
  { id: 9, name: 'Combo Sơ Mi Oxford & Quần Xám Trầm', price: '440.000đ', image: '/images/OutfitSection/f9.png' },
  { id: 10, name: 'Set Smart Casual Cho Developer', price: '400.000đ', image: '/images/OutfitSection/f10.png' },
  { id: 11, name: 'Combo Áo Khoác Nhẹ & Sơ Mi Trắng', price: '590.000đ', image: '/images/OutfitSection/f11.png' }
])

// 2. BIẾN QUẢN LÝ TRẠNG THÁI MODAL VÀ KÍCH THƯỚC (SIZE)
const isModalOpen = ref(false)
const selectedProduct = ref(null)

const sizes = ['S', 'M', 'L', 'XL', 'XXL']
const selectedSize = ref('L') // Mặc định luôn chọn L

// Hàm mở modal và lấy dữ liệu sản phẩm
const openProductModal = (product) => {
  selectedProduct.value = product
  selectedSize.value = 'L' // Reset về size L mỗi khi mở áo mới
  isModalOpen.value = true
}

// Hàm đóng modal
const closeProductModal = () => {
  isModalOpen.value = false
  selectedProduct.value = null
}
</script>

<template>
  <section class="w-full py-20 bg-[#fff8f3]">
    <div class="max-w-[1400px] mx-auto px-4 md:px-10">
      
      <div class="mb-14 text-center md:text-left">
        <h2 class="text-3xl md:text-5xl font-light uppercase text-slate-900 tracking-wide mb-4">
          OUTFIT ĐI LÀM <span class="text-[#705847]">HAY ĐI CHƠI?</span>
        </h2>
        <p class="text-slate-700 font-light text-base md:text-lg opacity-90 max-w-2xl">
          Tủ đồ của bạn cần gì, click vào đó. ChongDoo đã lên set sẵn sàng!
        </p>
      </div>

      <div class="flex flex-col lg:flex-row gap-6">
        
        <div @click="goToOfficeCollection" class="lg:w-1/3 relative group cursor-pointer overflow-hidden rounded-2xl shadow-sm h-[600px]">
          <img src="/images/OutfitSection/f1.png" alt="Team Công Sở" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-700 z-0">
          <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent z-10 pointer-events-none"></div>
          <div class="absolute bottom-0 left-0 w-full p-8 text-white flex flex-col justify-end z-20">
             <h3 class="font-medium text-xl mb-1 tracking-wide">TEAM CÔNG SỞ</h3>
             <h4 class="font-light text-sm opacity-80 mb-4">(THE MINIMALIST / THE CEO)</h4>
             <p class="text-sm text-gray-200 font-light mb-6 leading-relaxed">Sơ mi phẳng lì, quần tây bao lịch lãm. Đi làm hay đi tiệc đều bảnh.</p>
             <button class="border border-white/70 bg-white/10 backdrop-blur-sm group-hover:bg-white group-hover:text-slate-900 text-white text-xs font-medium py-3 px-6 rounded-full transition-all duration-300 uppercase w-fit tracking-wider">
               Lịch Lãm Chuyên Nghiệp
             </button>
          </div>
        </div>

        <div class="lg:w-2/3 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
          <div v-for="product in outfitProducts" :key="product.id" @click="openProductModal(product)" class="aspect-[2/3] rounded-2xl overflow-hidden cursor-pointer hover:-translate-y-2 shadow-sm hover:shadow-md transition-all duration-300 border border-white/50 relative group">
            <img :src="product.image" :alt="product.name" class="absolute inset-0 w-full h-full object-cover">
          </div>
        </div>
        
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
        <span class="text-sm text-[#705847] mb-2 uppercase tracking-widest font-light">Set Đồ Gợi Ý</span>
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
          <button class="w-full bg-slate-900 text-white font-bold py-4 rounded-full shadow-lg hover:bg-slate-700 transition duration-300 uppercase tracking-wider">
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