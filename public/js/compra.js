document.addEventListener('DOMContentLoaded', () => {
    // Obtener el carrito del localStorage
    const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    const contenidoCarrito = document.querySelector('#contenido-carrito');
    const totalPrecio = document.querySelector('#total-precio');
    const btnFinalizarCompra = document.querySelector('#btn-finalizar-compra');
    
    // Función para calcular el total
    function calcularTotal() {
        let total = 0;
        carrito.forEach(producto => {
            total += parseFloat(producto.precio.replace('$', '')) * producto.cantidad;
        });
        totalPrecio.textContent = total.toFixed(2);
    }

    // Función para renderizar el carrito en la tabla
    function renderizarCarrito() {
        contenidoCarrito.innerHTML = '';
        carrito.forEach(producto => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td><img src="${producto.imagen}" class="carrito-img"></td>
                <td>${producto.nombre}</td>
                <td>${producto.precio}</td>
                <td>${producto.cantidad}</td>
                <td>${(parseFloat(producto.precio.replace('$', '')) * producto.cantidad).toFixed(2)}</td>
            `;
            contenidoCarrito.appendChild(row);
        });
        calcularTotal();
    }

    // Event listener para finalizar la compra
    btnFinalizarCompra.addEventListener('click', () => {
        alert('Compra finalizada. ¡Gracias por tu compra!');
        // Aquí puedes agregar la lógica para procesar la compra
        // Como enviar los datos a un servidor o similar
        localStorage.removeItem('carrito');
        window.location.href = 'index.php'; // Redirigir a otra página después de la compra
    });

    // Renderizar carrito al cargar la página
    renderizarCarrito();
});
