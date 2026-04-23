import { ref, computed } from 'vue'

// State dùng chung (singleton) cho toàn bộ app
const cartItems = ref([])
const isCartOpen = ref(false)

export function useCart() {
  // Tổng số lượng sản phẩm trong giỏ
  const cartCount = computed(() =>
    cartItems.value.reduce((sum, item) => sum + item.quantity, 0)
  )

  // Tổng tiền
  const cartTotal = computed(() => {
    return cartItems.value.reduce((sum, item) => {
      const price = parseInt(item.price.replace(/\D/g, ''))
      return sum + price * item.quantity
    }, 0)
  })

  // Thêm sản phẩm vào giỏ
  const addToCart = (product, size = 'L') => {
    const existing = cartItems.value.find(
      (i) => i.id === product.id && i.size === size
    )
    if (existing) {
      existing.quantity++
    } else {
      cartItems.value.push({
        ...product,
        size,
        quantity: 1,
        cartKey: `${product.id}-${size}-${Date.now()}`
      })
    }
    isCartOpen.value = true
  }

  // Tăng số lượng
  const increaseQty = (cartKey) => {
    const item = cartItems.value.find((i) => i.cartKey === cartKey)
    if (item) item.quantity++
  }

  // Giảm số lượng
  const decreaseQty = (cartKey) => {
    const item = cartItems.value.find((i) => i.cartKey === cartKey)
    if (item) {
      if (item.quantity > 1) {
        item.quantity--
      } else {
        removeFromCart(cartKey)
      }
    }
  }

  // Xóa sản phẩm
  const removeFromCart = (cartKey) => {
    cartItems.value = cartItems.value.filter((i) => i.cartKey !== cartKey)
  }

  // Mở/đóng cart drawer
  const openCart = () => { isCartOpen.value = true }
  const closeCart = () => { isCartOpen.value = false }

  return {
    cartItems,
    cartCount,
    cartTotal,
    isCartOpen,
    addToCart,
    increaseQty,
    decreaseQty,
    removeFromCart,
    openCart,
    closeCart
  }
}
