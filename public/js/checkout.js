document.addEventListener('DOMContentLoaded', () => {
    cargarCarrito();
    document.getElementById('checkout-form').addEventListener('submit', procesarCompra);
});

function cargarCarrito() {
    const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    const resumen = document.querySelector('#resumen-pedido tbody');

    carrito.forEach(item => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td><img src="${item.imagen}" width="100"></td>
            <td>${item.titulo}</td>
            <td>${item.precio}</td>
        `;
        resumen.appendChild(row);
    });
}

function procesarCompra(e) {
    e.preventDefault();
    const nombre = document.getElementById('nombre').value;
    const email = document.getElementById('email').value;
    const direccion = document.getElementById('direccion').value;
    const tarjeta = document.getElementById('tarjeta').value;
    const fechaExpiracion = document.getElementById('fecha-expiracion').value;
    const cvv = document.getElementById('cvv').value;

    if (nombre && email && direccion && tarjeta && fechaExpiracion && cvv) {
        alert('Compra realizada con éxito');
        localStorage.removeItem('carrito');
        window.location.href = 'index.html';
    } else {
        alert('Por favor, complete todos los campos');
    }
}
