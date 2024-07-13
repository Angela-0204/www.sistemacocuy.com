document.getElementById('addProductButton').addEventListener('click', function() {
    var productSelect = document.getElementById('productSelect');
    var selectedProduct = productSelect.options[productSelect.selectedIndex];
    var productName = selectedProduct.value;
    var productPrice = parseFloat(selectedProduct.getAttribute('data-price'));
    var quantity = parseInt(document.getElementById('quantity').value);
    var subTotal = productPrice * quantity;

    var orderItems = document.getElementById('order-items');
    var newRow = document.createElement('tr');
    newRow.innerHTML = `
      <td>${productName}</td>
      <td>${quantity}</td>
      <td>${productPrice.toFixed(2)}</td>
      <td>${subTotal.toFixed(2)}</td>
    `;
    orderItems.appendChild(newRow);

    // Close the modal
    $('#productModal').modal('hide');
  });