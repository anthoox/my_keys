
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

// Script para copiar nombre de usuario en portapapeles
document.addEventListener("DOMContentLoaded", () => {

  // Selecciona todos los botones de copiar
  const btnsCopy = document.querySelectorAll('.btn-copy');

  btnsCopy.forEach(btn => {

    btn.addEventListener('click', (e) => {

      // Contenedor donde está el usuario
      const container = e.currentTarget.closest('.mb-3');

      // Obtiene el texto del usuario (evitando el "Usuario:")
      const username = container.querySelector('p').textContent.replace('Usuario:', '').trim();
/**
 * todo mostrar errores en pantalla o no mostrarlos
 */
      // Copiar al portapapeles
      navigator.clipboard.writeText(username)
        .then(() => {
          console.log("Copiado:", username);
        })
        .catch(err => {
          console.error("Error al copiar:", err);
        });

    });

  });

});

// Script para copiar contraseña
document.addEventListener("DOMContentLoaded", () =>{
  const copyButtons = document.querySelectorAll("[data-copy]");

  copyButtons.forEach(btn => {
    btn.addEventListener("click",async() => {
      const id = btn.dataset.copy;
      try {
        // Petición para obtener la contraseña desencriptada
        const response = await fetch(`${BASE_URL}/?c=services&a=getPassword&id=${id}`);
        const data = await response.json();

/**
 * TODO mostrar mensajes de copiado o error
 */
        if (data.success) {
          await navigator.clipboard.writeText(data.password);
          console.log("Contraseña copiada:");

          // aquí puedes mostrar un mensaje bonito en tu UI
        } else {
          console.error("Error:", data.message);
        }

      } catch (error) {
        console.error("Fallo al copiar:", error);
      }
    })
  })

  const showButtons = document.querySelectorAll("[data-show]");

  showButtons.forEach(btn => {
    btn.addEventListener('click', async () => {
      const id = btn.dataset.show;
      // Seleccionar el span que contiene los asteriscos
      const passwordSpan = btn.closest(".mb-3").querySelector(".password");
      const passwords = document.querySelectorAll('.password');
    
      if (!passwordSpan) return;

      // Toggle: si ya está visible, ocultar
      if (passwordSpan.dataset.visible === "true") {
        passwordSpan.textContent = "********";
        passwordSpan.dataset.visible = "false";
        return;
      }

      try {
        // Petición para obtener la contraseña desencriptada
        const response = await fetch(`${BASE_URL}/?c=services&a=getPassword&id=${id}`);
        const data = await response.json();

        if (data.success) {
          // Configuración para solo mostrar una clave a la vez
          passwords.forEach(pass => {
            pass.textContent = "********";
          })
          // Mostrar la contraseña en el span
          passwordSpan.textContent = data.password;
          passwordSpan.dataset.visible = "true"; // marcar como visible
        } else {
          console.error("Error:", data.message);
        }

      } catch (error) {
        console.error("Fallo al obtener la contraseña:", error);
      }
    })
  })
})