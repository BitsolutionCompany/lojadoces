const checkbox = document.getElementById('menu-mobile');
const modal = document.querySelector('.modal');

// Função para habilitar ou desabilitar o overflow do body
function toggleBodyOverflow(isModalOpen) {
    if (isModalOpen) {
      document.body.classList.add('modal-open'); // Adiciona classe que desabilita o overflow
    } else {
      document.body.classList.remove('modal-open'); // Remove a classe para permitir o overflow
    }
}

// Evento para abrir ou fechar o modal baseado no estado do checkbox
checkbox.addEventListener('change', () => {
  if (checkbox.checked) {
    modal.style.visibility = 'visible'; // Mostrar modal
    modal.style.opacity = 1; // Mostrar modal
    toggleBodyOverflow(true); //Desabilita o oveflow
    // console.log('Modal aberto:', checkbox.checked);
  } else {
    modal.style.visibility = 'hidden'; 
    modal.style.opacity = 0; // Esconder modal
    toggleBodyOverflow(false); //Habilita o overflow
    // console.log('Modal fechado:', checkbox.checked);
  }
});