<script setup>
import { ref } from 'vue'

// Tạo biến tham chiếu đến cái khung chứa các thẻ để điều khiển cuộn
const sliderContainer = ref(null)

// Hàm cuộn qua trái
const scrollLeft = () => {
  if (sliderContainer.value) {
    sliderContainer.value.scrollBy({ left: -320, behavior: 'smooth' })
  }
}

// Hàm cuộn qua phải
const scrollRight = () => {
  if (sliderContainer.value) {
    sliderContainer.value.scrollBy({ left: 320, behavior: 'smooth' })
  }
}

// Dữ liệu tăng lên 6 thẻ để bạn test tính năng trượt
const techCards = ref([
  { id: 1, image: '/images/TechnologySection/f1.png', icon: '☁️', title: 'CLOUDTOUCH™', subtitle: 'Mềm hơn bạn nghĩ' },
  { id: 2, image: '/images/TechnologySection/f2.png', icon: '❄️', title: 'ICEVIBES™', subtitle: 'Mát mẻ thoải mái' },
  { id: 3, image: '/images/TechnologySection/f3.png', icon: '🛡️', title: 'DURABLETEX™', subtitle: 'Chống mài mòn' },
  { id: 4, image: '/images/TechnologySection/f4.png', icon: '🍃', title: 'STAYFRESH™', subtitle: 'Kháng khuẩn khử mùi' },
  { id: 5, image: '/images/TechnologySection/f5.png', icon: '💨', title: 'AIRDRY™', subtitle: 'Nhanh khô thoáng khí' },
  { id: 6, image: '/images/TechnologySection/f6.png', icon: '✨', title: 'FLEXFIT™', subtitle: 'Co giãn linh hoạt' }
])
</script>

<template>
  <section class="w-full bg-[#f3e7dd] py-20 relative overflow-hidden">
    <div class="max-w-[1400px] mx-auto px-4 md:px-10 relative z-10 text-center">
      
      <div class="mb-14">
        <h2 class="text-3xl md:text-5xl font-light text-slate-900 mb-4 uppercase leading-tight tracking-wide">
          CHẤT LIỆU CAO CẤP<br>
          <span class="text-[#705847]">ĐƯỢC THIẾT KẾ CHO MỖI DÁNG NGƯỜI</span>
        </h2>
        <p class="text-slate-700 font-light text-base md:text-lg leading-relaxed mx-auto max-w-2xl opacity-90">
          Mỗi công nghệ vải được chọn lọc kỹ càng để nâng tầm phong cách, giúp bạn tự tin mặc đẹp và cảm nhận sự thoải mái trọn vẹn.
        </p>
      </div>

      <div class="relative group">
        
        <button @click="scrollLeft" 
                class="absolute left-0 top-[40%] -translate-y-1/2 -ml-2 md:-ml-6 z-20 w-10 h-10 md:w-12 md:h-12 bg-white/80 hover:bg-white rounded-full flex items-center justify-center shadow-md text-slate-600 transition-all opacity-0 group-hover:opacity-100">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
        </button>

        <div ref="sliderContainer" class="flex overflow-x-auto snap-x hide-scrollbar gap-6 pb-8 pt-4 px-2">
          
          <div v-for="card in techCards" :key="card.id" 
               class="snap-start flex-none w-[280px] md:w-[320px] text-left">
            
            <div class="w-full aspect-[4/3] rounded-2xl overflow-hidden mb-5 shadow-sm border border-white/50 bg-white">
              <img :src="card.image" :alt="card.title" class="w-full h-full object-cover hover:scale-105 transition duration-700">
            </div>
            
            <div class="px-2">
              <div class="flex items-center gap-3 mb-1">
                <div class="w-8 h-8 rounded-full bg-[#e6f0f9] text-[#1b4965] flex items-center justify-center text-sm shadow-inner">
                  {{ card.icon }}
                </div>
                <h3 class="font-medium text-base text-slate-900 tracking-wide">{{ card.title }}</h3>
              </div>
              
              <p class="text-sm text-slate-600 mb-4 pl-11">{{ card.subtitle }}</p>
              
              <a href="#" class="inline-block text-[13px] font-medium text-slate-900 border-b border-slate-900 pb-0.5 ml-11 uppercase hover:text-[#705847] hover:border-[#705847] transition-colors">
                KHÁM PHÁ NGAY
              </a>
            </div>

          </div>
        </div>

        <button @click="scrollRight" 
                class="absolute right-0 top-[40%] -translate-y-1/2 -mr-2 md:-mr-6 z-20 w-10 h-10 md:w-12 md:h-12 bg-white/80 hover:bg-white rounded-full flex items-center justify-center shadow-md text-slate-600 transition-all opacity-0 group-hover:opacity-100">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
        </button>

      </div>
    </div>
  </section>
</template>

<style scoped>
/* Ẩn thanh cuộn mặc định của trình duyệt */
.hide-scrollbar::-webkit-scrollbar {
  display: none;
}
.hide-scrollbar {
  -ms-overflow-style: none;
  scrollbar-width: none;
  scroll-behavior: smooth; /* Cuộn mượt mà */
}
</style>