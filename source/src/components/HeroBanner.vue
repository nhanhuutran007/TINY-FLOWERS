<script setup>
import { ref } from 'vue'
// Tùy vào việc bạn có xài Vue Router không, ở đây dùng cách điều hướng cơ bản nhất
const goToSalePage = () => {
  // Đẩy URL mới vào thanh địa chỉ mà không tải lại trang
  window.history.pushState({}, '', '/sale')
  // Phát ra một sự kiện (event) để báo cho App.vue biết URL đã thay đổi
  window.dispatchEvent(new Event('popstate'))
}

const bodyForms = ref([
  { id: 'F1', name: 'FORM OVERSIZED', sub: '(Dáng Rộng Thoải Mái)', image: '/images/HeroBanner/f1.png' },
  { id: 'F2', name: 'FORM BAGGY', sub: '(Dáng Ống Rộng Baggy)', image: '/images/HeroBanner/f2.png' },
  { id: 'F3', name: 'FORM RELAXED  STRAIGHT', sub: '(Dáng Thẳng Thoải Mái)', image: '/images/HeroBanner/f3.png' },
  { id: 'F4', name: 'FORM CROPPED BOXY', sub: '(Dáng Hộp Cắt Ngắn)', image: '/images/HeroBanner/f4.png' },
  { id: 'F5', name: 'FORM BOXY', sub: '(Dáng Hộp)', image: '/images/HeroBanner/f5.png' }
])
</script>

<template>
  <section @click="goToSalePage" class="bg-[#f3e7dd] w-full py-14 overflow-hidden cursor-pointer hover:bg-[#ebdccc] transition-colors duration-300">
    <div class="mx-auto w-full max-w-7xl px-4 md:px-10 flex flex-col md:flex-row items-center justify-between">
      <div class="md:w-2/5 text-slate-900 z-10 mb-10 md:mb-0 pointer-events-none">
        <h1 class="text-2xl md:text-4xl font-light mb-4 uppercase leading-tight text-center">
          FORM CHUẨN GEN Z VIỆT  <br><span class="text-[#705847]">LUXURY KHÔNG CẦN ĐẮT</span>
        </h1>
        <p class="mb-8 text-sm md:text-base leading-relaxed opacity-90 text-center">
          Tủ đồ luxury dành riêng cho Gen Z nam Việt, tinh tế từ chất liệu đến từng đường may.
        </p>
        <div class="flex justify-center pointer-events-auto">
          <button class="px-8 py-3 rounded-full border border-slate-900 text-slate-900 font-bold hover:bg-slate-950 hover:text-white transition duration-300 shine-button relative overflow-hidden">
            <span class="relative z-10">KHÁM PHÁ NGAY</span>
            <span class="absolute inset-0 shine-effect"></span>
          </button>
        </div>
      </div>
      <div class="md:w-3/5 flex justify-center md:justify-end gap-3 md:gap-5 h-[400px] md:h-[480px] pointer-events-none">
        <div v-for="form in bodyForms" :key="form.id" class="w-28 md:w-44 relative group flex flex-col items-center h-[380px] md:h-[470px]">
          <div class="w-full h-[320px] md:h-[400px] overflow-hidden rounded-[32px] bg-[#fff4ec] transition-transform duration-500 group-hover:-translate-y-4 shadow-sm border border-white/50">
            <img :src="form.image" :alt="form.name" class="w-full h-full object-cover object-[75%_center]">
          </div>
          <div class="text-slate-900 text-center mt-4 opacity-90 group-hover:opacity-100 transition-opacity h-[40px] md:h-[50px] flex flex-col justify-center">
            <p class="text-xs md:text-sm font-bold">{{ form.id }} - {{ form.name }}</p>
            <p class="text-[10px] md:text-xs">{{ form.sub }}</p>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
@keyframes shine { 0% { left: -100%; } 100% { left: 100%; } }
.shine-button { position: relative; }
.shine-effect {
  position: absolute; top: 0; left: -100%; width: 100%; height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
  animation: shine 2s infinite;
}
</style>