
document.addEventListener('DOMContentLoaded', () => {
    const productsGrid = document.querySelector('.products-grid');
    const cartSidebar = document.querySelector('.cart-sidebar');
    const cartItemsContainer = document.getElementById('cart-items-container');
    const cartEmpty = document.getElementById('cart-empty-message');
    const cartSummary = document.getElementById('cart-summary');
    const cartActions = document.getElementById('cart-actions');
    const totalElement = document.getElementById('total-price'); 
    const subtotalElement = document.getElementById('subtotal-price');

    if (!productsGrid || !cartSidebar) return;

   
    function formatCurrency(number) {
        return number.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
    }

    function updateCartUI(cartData) {
        if (!cartData || Object.keys(cartData).length === 0) {
            
            cartEmpty.style.display = 'block';
            cartItemsContainer.innerHTML = '';
            cartSummary.style.display = 'none';
            cartActions.style.display = 'none';
            cartSidebar.classList.remove('has-items');
        } else {
            let total = 0;
            let cartHtml = '';
            
            for (const id in cartData) {
                const item = cartData[id];
                const itemTotal = item.gia * item.so_luong;
                total += itemTotal;
                
                cartHtml += `
                    <div class="cart-item" data-id="${item.id_mon}">
                        <button class="remove-btn" data-id="${item.id_mon}">x</button>
                        <div class="cart-item-header">
                            <div class="item-image">
                                <img src="${item.hinh_anh}" alt="${item.ten_mon}">
                            </div>
                            <div class="item-info">
                                <div class="cart-item-name">${item.ten_mon}</div>
                                <div class="cart-item-vat">VAT: 8%</div>
                            </div>
                        </div>
                        
                        ${item.mo_ta ? `
                        <div class="cart-item-details">
                            <span style="font-weight: bold;">Mô tả:</span>
                            <p style="margin: 5px 0; font-size: 13px; color: #666;">${item.mo_ta}</p>
                        </div>
                        ` : ''}
                        
                        <div class="cart-item-bottom">
                            <div class="quantity-control">
                                <button class="qty-minus" data-action="minus" data-id="${item.id_mon}">-</button>
                                <input type="text" value="${item.so_luong}" readonly>
                                <button class="qty-plus" data-action="plus" data-id="${item.id_mon}">+</button>
                            </div>
                            <div class="item-price-subtotal">
                                ${formatCurrency(itemTotal)}
                            </div>
                        </div>
                    </div>
                `;
            }


            cartItemsContainer.innerHTML = cartHtml;
            subtotalElement.textContent = formatCurrency(total);
            const vat = total * 0.08;
            // const shipping = 30000;
            totalElement.textContent = formatCurrency(total);

            cartEmpty.style.display = 'none';
            cartItemsContainer.style.display = 'flex';
            cartSummary.style.display = 'block';
            cartActions.style.display = 'flex';
            cartSidebar.classList.add('has-items');
            

            attachCartEventListeners();
        }
    }

    function attachCartEventListeners() {
       
        document.querySelectorAll('.qty-plus, .qty-minus').forEach(btn => {
            btn.addEventListener('click', function() {
                const action = this.dataset.action;
                const productId = this.dataset.id;
                updateQuantity(productId, action);
            });
        });

        document.querySelectorAll('.remove-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const productId = this.dataset.id;
                removeFromCart(productId);
            });
        });
    }



    function updateQuantity(productId, action) {
        fetch('/WD20302-PRO1014_N5/nhahang/public/update_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id_mon=${productId}&action=${action}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateCartUI(data.cart_items);
            } else {
                alert('Lỗi: ' + data.message);
            }
        })
        .catch(error => console.error('Lỗi kết nối:', error));
    }

  
    function removeFromCart(productId) {
        fetch('/WD20302-PRO1014_N5/nhahang/public/remove_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id_mon=${productId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateCartUI(data.cart_items);
            } else {
                alert('Lỗi: ' + data.message);
            }
        })
        .catch(error => console.error('Lỗi kết nối:', error));
    }

    productsGrid.addEventListener('click', (event) => {
        const addButton = event.target.closest('.add-to-cart-btn');
        if (addButton) {
            const productId = addButton.dataset.productId;

            fetch('/WD20302-PRO1014_N5/nhahang/public/add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id_mon=${productId}` 
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                 
                    updateCartUI(data.cart_items);
                } else {
                    alert('Lỗi: ' + data.message);
                }
            })
            .catch(error => console.error('Lỗi kết nối:', error));
        }
    });
    
    
    fetch('/WD20302-PRO1014_N5/nhahang/public/get_cart.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateCartUI(data.cart_items);
            }
        })
        .catch(error => console.error('Lỗi tải giỏ hàng:', error));
    
});
// Thêm vào cuối cart.js
const datHangBtn = document.getElementById('dat-hang-btn');
if (datHangBtn) {
    datHangBtn.addEventListener('click', () => {
        if (Object.keys(cartItems).length === 0) {
            alert('Giỏ hàng rỗng!');
            return;
        }
        window.location.href = '/WD20302-PRO1014_N5/nhahang/public/booking_info.php'; // Chuyển đến form
    });
}