document.addEventListener('DOMContentLoaded', () => {
    // Obtener el carrito del localStorage o inicializarlo vacío
    let carrito = JSON.parse(localStorage.getItem('carrito')) || [];

    // Elementos del DOM
    const listaCarrito = document.querySelector('#lista-carrito tbody');
    const btnComprar = document.querySelector('#comprar');
    const btnVaciarCarrito = document.querySelector('#vaciar-carrito');

    // Función para renderizar el carrito
    function renderizarCarrito() {
        // Limpiar carrito
        listaCarrito.innerHTML = '';
        // Renderizar cada producto
        carrito.forEach(producto => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td><img src="${producto.imagen}" width="100"></td>
                <td>${producto.nombre}</td>
                <td>${producto.precio}</td>
                <td><a href="#" class="borrar-producto" data-id="${producto.id}">X</a></td>
            `;
            listaCarrito.appendChild(row);
        });
    }

    // Función para vaciar el carrito
    function vaciarCarrito() {
        carrito = [];
        localStorage.setItem('carrito', JSON.stringify(carrito));
        renderizarCarrito();
    }

    // Event listener para botón comprar
    btnComprar.addEventListener('click', (e) => {
        e.preventDefault();
        console.log('Botón comprar clickeado');  // Log para verificar el evento de clic
        if (carrito.length === 0) {
            alert('El carrito está vacío.');
        } else {
            // Guardar el carrito en localStorage y redirigir a compra.php
            localStorage.setItem('carrito', JSON.stringify(carrito));
            window.location.href = '?pagina=hacer_compra';
        }
    });

    // Event listener para vaciar carrito
    btnVaciarCarrito.addEventListener('click', (e) => {
        e.preventDefault();
        console.log('Botón vaciar carrito clickeado');  // Log para verificar el evento de clic
        vaciarCarrito();
    });

    // Event listener para agregar al carrito
    document.querySelectorAll('.agregar-carrito').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            console.log('Botón agregar al carrito clickeado');  // Log para verificar el evento de clic
            const producto = e.target.parentElement.parentElement;
            const infoProducto = {
                imagen: producto.querySelector('img').src,
                nombre: producto.querySelector('h3').textContent,
                precio: producto.querySelector('.precio').textContent,
                id: e.target.dataset.id
            };
            carrito.push(infoProducto);
            localStorage.setItem('carrito', JSON.stringify(carrito));
            renderizarCarrito();
        });
    });

    // Renderizar carrito al cargar la página
    renderizarCarrito();

    // Event listener para borrar producto del carrito
    listaCarrito.addEventListener('click', (e) => {
        if (e.target.classList.contains('borrar-producto')) {
            console.log('Botón borrar producto clickeado');  // Log para verificar el evento de clic
            const productoId = e.target.dataset.id;
            carrito = carrito.filter(producto => producto.id !== productoId);
            localStorage.setItem('carrito', JSON.stringify(carrito));
            renderizarCarrito();
        }
    });
});
