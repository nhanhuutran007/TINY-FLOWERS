<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

// 1. Nhập tất cả các mảnh ghép (Components) của trang chủ
import AppHeader from './components/AppHeader.vue'
import HeroBanner from './components/HeroBanner.vue'
import MarqueeSlider from './components/icons/MarqueeSlider.vue'
import BodyFormsList from './components/icons/BodyFormsList.vue'
import TechnologySection from './components/TechnologySection.vue'
import OutfitSection from './components/OutfitSection.vue'
import ChillTeamSection from './components/ChillTeamSection.vue'
import WeekendVibesSection from './components/WeekendVibesSection.vue'
import StyleSetSection from './components/StyleSetSection.vue'
import MatchReadySection from './components/MatchReadySection.vue'
import VideoLookbook from './components/VideoLookbook.vue'
import GuaranteeSection from './components/GuaranteeSection.vue'
import PolicyCards from './components/PolicyCards.vue'
import AppFooter from './components/AppFooter.vue'
import CartDrawer from './components/CartDrawer.vue'

// 2. Nhập các trang con (Pages)
import SalePage from './components/SalePage.vue'
import FormDetailPage from './components/FormDetailPage.vue' 
import CollectionDetailPage from './components/CollectionDetailPage.vue'

// 3. Biến quản lý trạng thái đường dẫn (Router cơ bản)
const currentPath = ref(window.location.pathname)

// Hàm lắng nghe sự thay đổi URL để cập nhật giao diện mà không cần tải lại trang
const updatePath = () => {
  currentPath.value = window.location.pathname
}

onMounted(() => {
  window.addEventListener('popstate', updatePath)
})

onUnmounted(() => {
  window.removeEventListener('popstate', updatePath)
})
</script>

<template>
  <div class="min-h-screen bg-[#f8f4f0] font-sans text-gray-900">
    
    <AppHeader />

    <!-- Cart Drawer (global, lives at body via Teleport inside CartDrawer) -->
    <CartDrawer />

    <template v-if="currentPath === '/sale'">
      <SalePage />
    </template>

    <template v-else-if="currentPath === '/form'">
      <FormDetailPage />
    </template>

    <template v-else-if="currentPath === '/collection'">
      <CollectionDetailPage />
    </template>

    <template v-else>
      <HeroBanner />
      <MarqueeSlider />
      <BodyFormsList />
      <TechnologySection /> 
      <OutfitSection />
      <ChillTeamSection />
      <WeekendVibesSection />
      <StyleSetSection />
      <MatchReadySection />
      <VideoLookbook />
      <GuaranteeSection />
      <PolicyCards />
    </template>

    <AppFooter />

  </div>
</template>