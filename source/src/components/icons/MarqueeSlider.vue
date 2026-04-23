<template>
  <div class="bg-black">
    <div class="mx-auto w-full max-w-7xl px-4 md:px-10 overflow-hidden">
      <div class="relative py-3 overflow-hidden">
        <div class="animate-marquee whitespace-nowrap text-white uppercase text-xs tracking-[0.3em]">
          <span class="mr-12">MIỄN PHÍ SHIP TOÀN QUỐC</span>
          <span class="mr-12">ĐỔI SIZE DỄ DÀNG</span>
          <span class="mr-12">BẢO HÀNH 365 NGÀY</span>
          <span class="mr-12">CHUẨN FORM NAM VIỆT</span>
          <span class="mr-12">GIÁ TỐT KHÔNG TẠO MÊ</span>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
@keyframes marquee { 0% { transform: translateX(0%); } 100% { transform: translateX(-50%); } }
.animate-marquee { display: inline-flex; padding-left: 100%; animation: marquee 15s linear infinite; }
</style>