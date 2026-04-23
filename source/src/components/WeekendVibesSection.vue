<script setup>
import { ref } from 'vue'

// Hàm chuyển trang tương ứng với từng vibe
const goToVibeCollection = (type) => {
  window.location.href = `/collection?type=${type}`
}

const vibeCards = ref([
  {
    id: 1,
    type: 'relax', // <-- Thêm type để phân loại chuyển trang
    title: 'TEAM THƯ GIÃN',
    subtitle: 'Set easy-wear cho ngày cuối tuần thảnh thơi.',
    image: '/images/WeekendVibesSection/f1.png',
    button: 'CHILL THEO PHONG CÁCH'
  },
  {
    id: 2,
    type: 'minimal', // <-- Thêm type
    title: 'TEAM TỐI GIẢN',
    subtitle: 'Màu trung tính, đường cắt chuẩn, mặc là hiện đại.',
    image: '/images/WeekendVibesSection/f2.png',
    button: 'MẶC NHẸ MÀ GẤP ĐÔI'
  },
  {
    id: 3,
    type: 'sport', // <-- Thêm type
    title: 'TEAM THỂ THAO',
    subtitle: 'Thoải mái vận động, vẫn giữ được chất street style.',
    image: '/images/WeekendVibesSection/f3.png',
    button: 'VẬN ĐỘNG NGAY'
  }
])
</script>

<template>
  <section class="w-full py-20 bg-[#fff8f3]">
    <div class="max-w-[1400px] mx-auto px-4 md:px-10">
      
      <div class="mb-14 text-center">
        <h2 class="text-3xl md:text-5xl font-light uppercase text-slate-900 tracking-wide mb-4">
          WEEKEND <span class="text-[#705847]">VIBES</span>
        </h2>
        <p class="text-slate-700 font-light text-sm md:text-lg opacity-90 max-w-2xl mx-auto">
          Bộ sưu tập nhẹ nhàng mà vẫn có cá tính, dành cho những lúc bạn muốn thoải mái mà vẫn giữ phong thái riêng.
        </p>
      </div>

      <div class="grid gap-8 md:grid-cols-3">
        <div v-for="card in vibeCards" :key="card.id" @click="goToVibeCollection(card.type)" class="group cursor-pointer bg-white rounded-[2.5rem] p-4 shadow-sm hover:shadow-2xl border border-[#e9ddd2]/60 transition-all duration-500 flex flex-col">
          
          <div class="relative w-full aspect-[4/5] bg-gradient-to-b from-[#f8f4f0] to-[#f3e7dd] rounded-[2rem] overflow-hidden flex items-center justify-center p-2">
            
            <img :src="card.image" :alt="card.title" class="w-full h-full object-contain drop-shadow-md group-hover:scale-105 transition-transform duration-700">
            
            <div class="absolute top-4 left-4 bg-white/90 backdrop-blur px-3 py-1.5 rounded-full text-[9px] font-bold text-[#705847] tracking-widest uppercase opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-sm">
              Weekend
            </div>
          </div>
          
          <div class="pt-8 pb-4 px-2 flex flex-col items-center text-center flex-grow">
            <h3 class="font-medium text-xl text-slate-900 mb-3 tracking-wide">{{ card.title }}</h3>
            <p class="text-sm text-slate-600 mb-8 font-light leading-relaxed flex-grow px-2">{{ card.subtitle }}</p>
            
            <button class="w-full rounded-2xl border border-[#705847] bg-transparent px-6 py-3.5 text-[12px] font-bold uppercase tracking-widest text-[#705847] group-hover:bg-[#705847] group-hover:text-white transition-all duration-300">
              {{ card.button }}
            </button>
          </div>
          
        </div>
      </div>
      
    </div>
  </section>
</template>