<script setup>
import { useCart } from '../composables/useCart.js'

const { cartItems, cartCount, cartTotal, isCartOpen, increaseQty, decreaseQty, removeFromCart, closeCart } = useCart()

const formatPrice = (num) => num.toLocaleString('vi-VN') + 'đ'
</script>

<template>
  <!-- Overlay -->
  <Teleport to="body">
    <Transition name="fade">
      <div v-if="isCartOpen" class="fixed inset-0 z-[300] flex justify-end">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="closeCart"></div>

        <!-- Drawer Panel -->
        <Transition name="slide-right">
          <div v-if="isCartOpen" class="relative flex flex-col bg-white w-full max-w-[420px] h-full shadow-2xl">

            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
              <div class="flex items-center gap-3">
                <svg viewBox="0 0 24 24" class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M6 7h12l1 12H5L6 7z"></path>
                  <path d="M9 7V5a3 3 0 0 1 6 0v2"></path>
                </svg>
                <h2 class="font-black text-slate-900 text-base uppercase tracking-widest">Giỏ Hàng</h2>
                <span v-if="cartCount > 0" class="bg-[#e3342f] text-white text-xs font-black w-5 h-5 rounded-full flex items-center justify-center">
                  {{ cartCount }}
                </span>
              </div>
              <button @click="closeCart" class="text-gray-400 hover:text-slate-900 transition bg-gray-100 hover:bg-gray-200 rounded-full p-2">
                <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>

            <!-- Empty State -->
            <div v-if="cartItems.length === 0" class="flex-1 flex flex-col items-center justify-center px-6 text-center">
              <div class="w-24 h-24 rounded-full bg-[#f8f4f0] flex items-center justify-center mb-6">
                <svg viewBox="0 0 24 24" class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5">
                  <path d="M6 7h12l1 12H5L6 7z"></path>
                  <path d="M9 7V5a3 3 0 0 1 6 0v2"></path>
                </svg>
              </div>
              <h3 class="font-black text-slate-900 text-lg mb-2">Giỏ hàng trống</h3>
              <p class="text-gray-400 text-sm mb-8 leading-relaxed">Chưa có sản phẩm nào trong giỏ. Hãy khám phá bộ sưu tập của chúng tôi!</p>
              <button @click="closeCart" class="px-8 py-3 bg-slate-900 text-white font-bold rounded-full hover:bg-slate-700 transition text-sm uppercase tracking-wider">
                Khám Phá Ngay
              </button>
            </div>

            <!-- Cart Items List -->
            <div v-else class="flex-1 overflow-y-auto px-6 py-4 flex flex-col gap-4">
              <TransitionGroup name="cart-item">
                <div
                  v-for="item in cartItems"
                  :key="item.cartKey"
                  class="flex gap-4 p-3 rounded-2xl bg-[#f8f4f0] border border-white hover:border-gray-200 transition group"
                >
                  <!-- Image -->
                  <div class="w-20 h-24 rounded-xl overflow-hidden flex-shrink-0 bg-white">
                    <img :src="item.image" :alt="item.name" class="w-full h-full object-cover" />
                  </div>

                  <!-- Info -->
                  <div class="flex-1 flex flex-col justify-between min-w-0">
                    <div>
                      <h4 class="text-xs font-semibold text-slate-900 line-clamp-2 leading-snug">{{ item.name }}</h4>
                      <div class="flex items-center gap-2 mt-1.5">
                        <span v-if="item.tag" class="bg-[#e3342f] text-white text-[9px] font-bold px-1.5 py-0.5 rounded uppercase">{{ item.tag }}</span>
                        <span class="text-[10px] text-gray-400 bg-white border border-gray-200 px-2 py-0.5 rounded-full font-semibold">Size {{ item.size }}</span>
                      </div>
                    </div>

                    <div class="flex items-center justify-between mt-2">
                      <!-- Quantity Control -->
                      <div class="flex items-center gap-2 bg-white rounded-full border border-gray-200 p-0.5">
                        <button
                          @click="decreaseQty(item.cartKey)"
                          class="w-7 h-7 rounded-full hover:bg-gray-100 transition flex items-center justify-center text-slate-900 font-black text-sm"
                        >−</button>
                        <span class="text-xs font-bold text-slate-900 w-4 text-center">{{ item.quantity }}</span>
                        <button
                          @click="increaseQty(item.cartKey)"
                          class="w-7 h-7 rounded-full hover:bg-slate-900 hover:text-white transition flex items-center justify-center text-slate-900 font-black text-sm"
                        >+</button>
                      </div>

                      <!-- Price -->
                      <span class="text-[#e3342f] font-black text-sm">{{ item.price }}</span>
                    </div>
                  </div>

                  <!-- Delete Button -->
                  <button
                    @click="removeFromCart(item.cartKey)"
                    class="self-start mt-1 text-gray-300 hover:text-[#e3342f] transition opacity-0 group-hover:opacity-100"
                  >
                    <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                  </button>
                </div>
              </TransitionGroup>
            </div>

            <!-- Footer: Total + Checkout -->
            <div v-if="cartItems.length > 0" class="border-t border-gray-100 px-6 py-5 bg-white">
              <!-- Subtotal -->
              <div class="flex justify-between items-center mb-2">
                <span class="text-sm text-gray-500 font-medium">Tạm tính</span>
                <span class="text-sm font-bold text-slate-900">{{ formatPrice(cartTotal) }}</span>
              </div>
              <div class="flex justify-between items-center mb-4">
                <span class="text-sm text-gray-500 font-medium">Phí vận chuyển</span>
                <span class="text-sm font-bold text-green-600">Miễn phí 🎉</span>
              </div>
              <div class="flex justify-between items-center mb-5 pb-5 border-b border-gray-100">
                <span class="text-base font-black text-slate-900 uppercase tracking-wide">Tổng Cộng</span>
                <span class="text-xl font-black text-[#e3342f]">{{ formatPrice(cartTotal) }}</span>
              </div>

              <!-- Buttons -->
              <button class="w-full bg-slate-900 text-white font-black py-4 rounded-full hover:bg-slate-700 transition duration-300 uppercase tracking-wider text-sm mb-3 shadow-lg">
                Thanh Toán Ngay →
              </button>
              <button @click="closeCart" class="w-full border border-gray-300 text-slate-700 font-medium py-3 rounded-full hover:bg-gray-50 transition text-sm">
                Tiếp Tục Mua Sắm
              </button>
            </div>

          </div>
        </Transition>
      </div>
    </Transition>
  </Teleport>
</template>

<style scoped>
.fade-enter-active, .fade-leave-active { transition: opacity 0.3s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }

.slide-right-enter-active, .slide-right-leave-active { transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1); }
.slide-right-enter-from, .slide-right-leave-to { transform: translateX(100%); }

.cart-item-enter-active { transition: all 0.3s ease; }
.cart-item-leave-active { transition: all 0.2s ease; }
.cart-item-enter-from { opacity: 0; transform: translateX(20px); }
.cart-item-leave-to { opacity: 0; transform: translateX(-20px); }
.cart-item-move { transition: transform 0.3s ease; }
</style>
