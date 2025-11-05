
/**
 * TODO corregir para que no se muestren los errores en consola
 */
document.addEventListener('DOMContentLoaded', () => {
  const editButtons = document.querySelectorAll('.edit-service-btn');
  const editId = document.getElementById('editServiceId');
  const editName = document.getElementById('editServiceName');
  const editUser = document.getElementById('editServiceUser');
  const editPassword = document.getElementById('editServicePassword');

  editButtons.forEach(button => {

    button.addEventListener('click', () => {
      editId.value = button.getAttribute('data-id');
      editName.value = button.getAttribute('data-name');
      editUser.value = button.getAttribute('data-user')
      // ⚠️ más adelante puedes descifrar la contraseña real si la tienes

      editPassword.value = '';
    });
  });

  // script para llevar id al formulario del modal para eliminar servicio
  const delModal = document.getElementById('delServiceModal');
  delModal.addEventListener('show.bs.modal', event => {
    const button = event.relatedTarget; // el botón que disparó el modal
    const serviceId = button.getAttribute('data-id');

    document.getElementById('deleteServiceId').value = serviceId;
  });

  // script para llevar id al formulario del modal para editar servicio
  const editModal = document.getElementById('editServiceModal');
  editModal.addEventListener('show.bs.modal', event => {

    const button = event.relatedTarget; // el botón que disparó el modal
    const serviceId = button.getAttribute('data-id');

    document.getElementById('editServiceId').value = serviceId;
  });

});

// Script Bootstrap para abrir el segundo modal

document.addEventListener("DOMContentLoaded", () => {

  // Botón dentro del primer modal
  const btnOpen = document.getElementById("openChangePasswordModal");

  // Los dos modales
  const modalWarningEl = document.getElementById("warningModal");
  const modalChangeEl = document.getElementById("changePasswordModal");

  if (btnOpen && modalWarningEl && modalChangeEl) {
    const modalWarning = bootstrap.Modal.getOrCreateInstance(modalWarningEl);
    const modalChange = bootstrap.Modal.getOrCreateInstance(modalChangeEl);

    btnOpen.addEventListener("click", () => {
      // Cerrar el primer modal
      modalWarning.hide();

      // Esperar a que se cierre y luego abrir el segundo
      modalWarningEl.addEventListener(
        "hidden.bs.modal",
        function handler() {
          modalChange.show();
          modalWarningEl.removeEventListener("hidden.bs.modal", handler);
        }
      );
    });
  }
});


