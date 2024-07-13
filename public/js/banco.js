function showModal(type) {
    let modalTitle = 'Detalles del Pago - ';

    switch(type) {
      case 'bank':
        modalTitle += 'Banco';
        break;
      case 'mobile':
        modalTitle += 'Pago Móvil';
        break;
      case 'credit':
        modalTitle += 'Tarjeta de Crédito';
        break;
      case 'qr':
        modalTitle += 'Pago Móvil QR';
        break;
    }

    document.getElementById('paymentModalLabel').innerText = modalTitle;
    $('#paymentModal').modal('show');
}