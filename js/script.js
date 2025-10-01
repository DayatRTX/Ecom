document.addEventListener("DOMContentLoaded", function () {
  const addToCartBtn = document.getElementById("add-to-cart-btn");

  if (addToCartBtn) {
    addToCartBtn.addEventListener("click", function () {
      const productId = this.getAttribute("data-product-id");
      const quantityInput = document.getElementById("quantity-input");
      const quantity = quantityInput.value;

      const formData = new FormData();
      formData.append("id_produk", productId);
      formData.append("quantity", quantity);

      this.textContent = "Menambahkan...";
      this.disabled = true;

      fetch("./api/tambah_keranjang.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            updateCartCounter(data.cart_count);
            this.textContent = "\u2714 Berhasil";
            setTimeout(() => {
              this.textContent = "Masukkan Keranjang";
              this.disabled = false;
            }, 500);
          } else {
            alert(data.message);
            this.textContent = "Masukkan Keranjang";
            this.disabled = false;
          }
        })
        .catch((error) => {
          console.error("Error:", error);
          alert("Terjadi kesalahan. Silakan coba lagi.");
          this.textContent = "Masukkan Keranjang";
          this.disabled = false;
        });
    });
  }

  const cartContainer = document.querySelector(".cart-container");

  if (cartContainer) {
    cartContainer.addEventListener("click", function (e) {
      if (e.target.classList.contains("qty-btn")) {
        const button = e.target;
        const action = button.dataset.action;
        const id = button.dataset.id;
        const input = document.querySelector(`.qty-input[data-id="${id}"]`);
        let currentValue = parseInt(input.value);

        if (action === "increase") {
          currentValue++;
        } else if (action === "decrease") {
          currentValue--;
        }

        input.value = currentValue;
        updateCartQuantity(id, currentValue);
      }
    });

    cartContainer.addEventListener("change", function (e) {
      if (e.target.classList.contains("qty-input")) {
        const input = e.target;
        const id = input.dataset.id;
        const value = parseInt(input.value);
        updateCartQuantity(id, value);
      }
    });
  }

  function updateCartQuantity(productId, quantity) {
    const formData = new FormData();
    formData.append("id_produk", productId);
    formData.append("quantity", quantity);

    fetch("./api/update_keranjang.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          const subtotalEl = document.getElementById(`subtotal-${productId}`);
          if (subtotalEl) {
            subtotalEl.textContent = data.new_subtotal_formatted;
          }

          const grandTotalEl = document.getElementById("grand-total");
          if (grandTotalEl) {
            grandTotalEl.textContent = data.new_grand_total_formatted;
          }

          updateCartCounter(data.cart_count);

          if (data.new_quantity <= 0) {
            const itemRow = document.getElementById(`item-row-${productId}`);
            if (itemRow) itemRow.remove();
          } else {
            const inputEl = document.querySelector(
              `.qty-input[data-id="${productId}"]`
            );
            if (inputEl) inputEl.value = data.new_quantity;
          }

          if (data.message) {
            alert(data.message);
          }
        }
      })
      .catch((error) => console.error("Error:", error));
  }

  function updateCartCounter(count) {
    const cartLink = document.querySelector(".cart-link");
    if (!cartLink) return;

    let counter = cartLink.querySelector(".cart-counter");

    if (count > 0) {
      if (!counter) {
        counter = document.createElement("span");
        counter.className = "cart-counter";
        cartLink.appendChild(counter);
      }
      counter.textContent = count;
    } else {
      if (counter) {
        counter.remove();
      }
    }
  }
});
