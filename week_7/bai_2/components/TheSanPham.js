
const TheSanPham = {
  props: {
    ten: {
      type: String,
      required: true
    },

    gia: {
      type: Number,
      required: true
    },

    anh: {
      type: String,
      default: "https://placehold.co/300x200?text=San+Pham"
    },

    moTa: {
      type: String,
      default: "Chưa có mô tả sản phẩm"
    },

    tonKho: {
      type: Number,
      default: 0
    }
  },

  data() {
    return {
      hienMoTa: false
    };
  },

  methods: {
    dinhDangTien(gia) {
      return gia.toLocaleString("vi-VN") + " đ";
    },

    muaSanPham() {
      if (this.tonKho > 0) {
        alert("Bạn đã chọn mua: " + this.ten);
      }
    }
  },

  template: `
    <div class="product-card">

      <img
        :src="anh"
        :alt="ten"
        class="product-image"
      >

      <h3>{{ ten }}</h3>

      <p class="price">
        {{ dinhDangTien(gia) }}
      </p>

      <p v-if="tonKho > 0" class="in-stock">
        Còn hàng ({{ tonKho }})
      </p>

      <p v-else class="out-stock">
        Hết hàng
      </p>

      <button
        class="detail-btn"
        @click="hienMoTa = !hienMoTa"
      >
        {{ hienMoTa ? 'Ẩn mô tả' : 'Xem mô tả' }}
      </button>

      <p v-if="hienMoTa" class="description">
        {{ moTa }}
      </p>

      <button
        class="buy-btn"
        :disabled="tonKho === 0"
        @click="muaSanPham"
      >
        Mua
      </button>

    </div>
  `
};
