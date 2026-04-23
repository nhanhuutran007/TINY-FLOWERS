<script setup>
import { ref } from 'vue'

// Đã đổi tên biến thành 'video' và thêm dấu '/' ở đầu đường dẫn
const reelsData = ref([
  {
    id: 1,
    title: 'CÁ TÍNH XUỐNG PHỐ',
    video: '/images/VideoLookbook/f1.mp4' 
  },
  {
    id: 2,
    title: 'THANH LỊCH ĐI LÀM',
    video: '/images/VideoLookbook/f2.mp4' 
  },
  {
    id: 3,
    title: 'TỐI GIẢN MỖI NGÀY',
    video: '/images/VideoLookbook/f3.mp4' 
  },
  {
    id: 4,
    title: 'TRẺ TRUNG NĂNG ĐỘNG',
    video: '/images/VideoLookbook/f4.mp4' 
  }
])
</script>

<template>
  <section class="w-full py-20 bg-[#f3e7dd]">
    <div class="max-w-[1400px] mx-auto px-4 md:px-10">
      
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
        
        <div v-for="reel in reelsData" :key="reel.id" class="flex flex-col group cursor-pointer">
          
          <div class="relative w-full aspect-[9/16] rounded-2xl overflow-hidden shadow-sm mb-6 bg-gray-200">
            
            <video 
              :src="reel.video" 
              class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
              autoplay 
              muted 
              loop 
              playsinline
            ></video>
            
            <div class="absolute inset-0 bg-black/10 group-hover:bg-black/30 transition-colors duration-300"></div>

            <div class="absolute inset-0 flex items-center justify-center">
              <div class="w-14 h-14 md:w-16 md:h-16 rounded-full border-[1.5px] border-white flex items-center justify-center bg-black/20 backdrop-blur-md group-hover:scale-110 group-hover:bg-white/20 transition-all duration-300">
                <svg class="w-6 h-6 md:w-8 md:h-8 text-white ml-1.5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M8 5v14l11-7z" />
                </svg>
              </div>
            </div>
          </div>
          
          <div class="flex justify-center">
            <button class="bg-[#949494] text-white px-6 py-2.5 rounded text-[11px] font-medium tracking-widest uppercase hover:bg-slate-900 transition-colors duration-300 shadow-sm w-full max-w-[200px]">
              {{ reel.title }}
            </button>
          </div>

        </div>

      </div>
    </div>
  </section>
</template>