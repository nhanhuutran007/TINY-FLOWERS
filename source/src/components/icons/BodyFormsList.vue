<script setup>
import { ref } from 'vue'

const goToFormPage = (formId) => {
  // Chuyển hướng sang trang mới và mang theo ID của form
  window.location.href = `/form?id=${formId}`
}

const bodyForms = ref([
  { id: 'F1', name: 'FORM OVERSIZED', sub: '(Dáng Rộng Thoải Mái)', desc: 'Form rộng thoái mái, layer cực đỉnh, mang đến proportion hiện đại và vibe street luxury GenZ',btn: 'OVERSIZED', image: '/images/BodyFormsList/f1.png' },
  { id: 'F2', name: 'FORM BAGGY', sub: '(Dáng Ống Rộng Baggy)', desc: 'Dáng ống rộng baggy tinh tế, thoải mái tối đa nhưng vẫn giữ form luxury chỉn chu.', btn: 'BAGGY', image: '/images/BodyFormsList/f2.png' },
  { id: 'F3', name: 'FORM RELAXED STRAIGHT', sub: '(Dáng Thẳng Thoải Mái)', desc: 'Dáng thẳng thoái mái, kết hợp hoàn hảo giữa hiện đại và dễ mặc hàng ngày.', btn: 'RELAXED STRAIGHT', image: '/images/BodyFormsList/f3.png' },
  { id: 'F4', name: 'FORM CROPPED BOXY', sub: '(Dáng Hộp Cắt Ngắn)', desc: 'Form hộp cắt ngắn trendy, tạo tỷ lệ cơ thể cực chất cho phong cách GenZ luxury.', btn: 'CROPPED BOXY', image: '/images/BodyFormsList/f4.png' },
  { id: 'F5', name: 'FORM BOXY', sub: '(Dáng Hộp)', desc: 'Rộng cực đại, nam tính, hack dáng chân dài.', btn: 'BOXY', image: '/images/BodyFormsList/f5.png' }
])
</script>

<template>
  <section class="bg-[#fff8f3] w-full py-20 overflow-hidden border-t border-white/50">
    <div class="max-w-[1400px] mx-auto px-4 md:px-10">
      
      <div class="text-center mb-16">
        <h2 class="text-3xl md:text-5xl font-light uppercase text-slate-900 tracking-wide mb-4">
          BODY NÀO CŨNG CÓ FORM <span class="text-[#705847]">"BAO CHUẨN"</span>
        </h2>
        <p class="text-slate-700 font-light text-base md:text-lg opacity-90 max-w-2xl mx-auto">
          Bụng bia, cò hương hay gymer vạm vỡ? ChongDoo cân tất! Không thiết kế tràn lan, chúng tôi chốt hạ 5 form dáng xịn nhất.
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-5 gap-6 text-center">
        <div v-for="form in bodyForms" :key="'detail-'+form.id" @click="goToFormPage(form.id)" class="flex flex-col group cursor-pointer">
          
          <div class="rounded-3xl overflow-hidden aspect-[3/4] mb-6 shadow-sm border border-white/50">
            <img :src="form.image" :alt="form.name" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
          </div>
          
          <h3 class="font-medium text-[15px] mb-2 text-slate-900 tracking-wide">{{ form.id }} - {{ form.name }}</h3>
          <p class="text-xs text-[#705847] mb-3">{{ form.sub }}</p>
          <p class="text-sm text-slate-600 mb-6 flex-grow font-light px-2">{{ form.desc }}</p>
          
          <button class="rounded-full border border-slate-900 px-4 py-2.5 text-[11px] font-medium uppercase tracking-widest text-slate-900 group-hover:bg-slate-900 group-hover:text-white transition-all duration-300 mx-4">
            {{ form.btn }}
          </button>
          
        </div>
      </div>
      
    </div>
  </section>
</template>