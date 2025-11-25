/* ============================================================================
    0. NO MOSTRAR MENSAJES EN CONSOLA
============================================================================ */
/**
 * Previene mostrar mensajes en consola.
 */
function debugLog(msg) {
  if (window.APP_DEBUG === true) {
    console.log(msg);
  }
}
window.APP_DEBUG = false;

/**
* Inicializa todos los módulos de la aplicación una vez cargado el DOM.
*/
document.addEventListener("DOMContentLoaded", () => {

  initEditModal();
  initDeleteModal();
  initChainModals();
  initCopyUsername();
  initCopyPassword();
  initShowPassword();
  initAutoHideErrors();
  debugLog("JS cargado y módulos inicializados");
});

/* ============================================================================
    1. MODAL DE EDICIÓN DE SERVICIO
============================================================================ */

/**
 * Relaciona los botones "Editar" con el modal de edición.
 * Rellena automáticamente los campos del formulario dentro del modal.
 */
function initEditModal() {
  const editButtons = document.querySelectorAll('.edit-service-btn');

  if (!editButtons.length) return;

  editButtons.forEach(button => {
    button.addEventListener('click', () => {
      document.getElementById('editServiceId').value = button.dataset.id;
      document.getElementById('editServiceName').value = button.dataset.name;
      document.getElementById('editServiceUser').value = button.dataset.user;

      // La contraseña nunca se precarga por seguridad
      document.getElementById('editServicePassword').value = "";
    });
  });
}

/* ============================================================================
    2. MODAL DE ELIMINACIÓN DE SERVICIO
============================================================================ */

/**
 * Lleva el ID del servicio al modal de confirmación de eliminación.
 */
function initDeleteModal() {
  const delModal = document.getElementById('delServiceModal');
  if (!delModal) return;

  delModal.addEventListener('show.bs.modal', event => {
    const button = event.relatedTarget;
    const serviceId = button.dataset.id;

    document.getElementById('deleteServiceId').value = serviceId;
  });
}

/* ============================================================================
    3. ENCADENAR MODALES
============================================================================ */

/**
 * Permite cerrar un modal de advertencia y abrir el modal de cambio de contraseña.
 * Esto evita comportamientos erráticos de Bootstrap cuando varios modales se encadenan.
 */
function initChainModals() {

  const btnOpen = document.getElementById("openChangePasswordModal");
  const modalWarningEl = document.getElementById("warningModal");
  const modalChangeEl = document.getElementById("changePasswordModal");

  if (!btnOpen || !modalWarningEl || !modalChangeEl) return;

  const modalWarning = bootstrap.Modal.getOrCreateInstance(modalWarningEl);
  const modalChange = bootstrap.Modal.getOrCreateInstance(modalChangeEl);

  btnOpen.addEventListener("click", () => {
    modalWarning.hide();

    modalWarningEl.addEventListener(
      "hidden.bs.modal",
      function handler() {
        modalChange.show();
        modalWarningEl.removeEventListener("hidden.bs.modal", handler);
      }
    );
  });
}

/* ============================================================================
    4. COPIAR NOMBRE DE USUARIO
============================================================================ */

/**
 * Copia el nombre de usuario al portapapeles cuando se hace clic en el botón.
 */
function initCopyUsername() {
  const btnsCopy = document.querySelectorAll('.btn-copy');

  if (!btnsCopy.length) return;

  btnsCopy.forEach(btn => {
    btn.addEventListener("click", (e) => {

      // Contenedor donde está el texto del usuario
      const container = e.currentTarget.closest('.mb-3');

      const username = container
        .querySelector('p')
        .textContent
        .replace('Usuario:', '')
        .trim();

      navigator.clipboard.writeText(username)
        .then(() => {
          debugLog("Nombre de usuario copiado.");
        })
        .catch(err => {
          console.error("Error al copiar nombre:", err);
        });
    });
  });
}

/* ============================================================================
    5. COPIAR CONTRASEÑA DESENCRIPTADA
============================================================================ */

/**
 * Copia la contraseña desencriptada obtenida por AJAX desde el backend.
 */
function initCopyPassword() {
  const copyButtons = document.querySelectorAll("[data-copy]");

  if (!copyButtons.length) return;

  copyButtons.forEach(btn => {
    btn.addEventListener("click", async () => {
      const id = btn.dataset.copy;

      try {
        const response = await fetch(`${BASE_URL}?c=services&a=getPassword&id=${id}`);

        const data = await response.json();

        if (data.success) {
          await navigator.clipboard.writeText(data.password);
          debugLog("Contraseña copiada.");
        } else {
          console.error("Error al obtener contraseña:", data.message);
        }

      } catch (error) {
        console.error("Fallo al copiar contraseña:", error);
      }
    });
  });
}

/* ============================================================================
    6. MOSTRAR / OCULTAR CONTRASEÑA (TOGGLE)
============================================================================ */

/**
 * Permite revelar una sóla contraseña a la vez.
 * Si vuelves a hacer clic se oculta.
 */
function initShowPassword() {
  const showButtons = document.querySelectorAll("[data-show]");

  if (!showButtons.length) return;

  showButtons.forEach(btn => {
    btn.addEventListener("click", async () => {

      const id = btn.dataset.show;
      const passwordSpan = btn.closest(".mb-3").querySelector(".password");

      if (!passwordSpan) return;

      // Si ya está visible, volver a ocultar
      if (passwordSpan.dataset.visible === "true") {
        passwordSpan.textContent = "********";
        passwordSpan.dataset.visible = "false";
        return;
      }

      try {
        const response = await fetch(`${BASE_URL}?c=services&a=getPassword&id=${id}`);
        const data = await response.json();

        if (data.success) {

          // Oculta todas las contraseñas visibles antes de mostrar una
          document.querySelectorAll(".password").forEach(p => {
            p.textContent = "********";
            p.dataset.visible = "false";
          });

          // Muestra la contraseña desencriptada
          passwordSpan.textContent = data.password;
          passwordSpan.dataset.visible = "true";

        } else {
          console.error("Error:", data.message);
        }

      } catch (error) {
        console.error("Error al obtener contraseña:", error);
      }

    });
  });
}

/**
 * initAutoHideErrors
 * ------------------
 * Gestiona automáticamente la desaparición de los mensajes de error o éxito
 * mostrados en la página dentro del contenedor con id="cnt-error".
 *
 * Funcionamiento:
 * 1. Detecta si ya existe un mensaje en la página al cargar el DOM:
 *    - Si existe, espera 3 segundos antes de aplicar la clase "fade-out".
 *    - Después de la transición (0.6s), oculta completamente el contenedor.
 *
 * 2. Monitorea cambios en el DOM usando MutationObserver:
 *    - Si se agrega dinámicamente un nuevo contenedor con id="cnt-error",
 *      se aplica el mismo comportamiento de ocultar tras 3 segundos.
 *
 * Esto permite que tanto mensajes ya existentes como mensajes generados
 * dinámicamente desaparezcan de forma automática y suave.
 *
 * Requisitos:
 * - El contenedor debe tener id="cnt-error".
 * - Se recomienda que la clase "fade-out" tenga una transición CSS definida
 *   para suavizar la desaparición (por ejemplo, opacity 0 y transición de 0.6s).
 *
 * Ejemplo CSS recomendado:
 *   #cnt-error.fade-out {
 *       opacity: 0;
 *       transition: opacity 0.6s ease-out;
 *   }
 */
function initAutoHideErrors() {

  // Observador para detectar nuevos mensajes dinámicos
  const observer = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
      mutation.addedNodes.forEach((node) => {
        // Verificar si el nodo agregado es el contenedor de error
        if (node.id === 'cnt-error') {
          // Esperar 3 segundos antes de aplicar fade-out
          setTimeout(() => {
            node.classList.add("fade-out");

            // Después de la transición, ocultar completamente
            setTimeout(() => {
              node.style.display = "none";
            }, 600); // Tiempo de transición definido en CSS
          }, 3000); // Tiempo visible antes de desaparecer
        }
      });
    });
  });

  // Configuración del observador: vigilar todos los hijos y subárboles del body
  observer.observe(document.body, { childList: true, subtree: true });

  // También aplicar efecto a cualquier mensaje que ya exista al cargar la página
  const existing = document.getElementById('cnt-error');
  if (existing) {
    setTimeout(() => {
      existing.classList.add("fade-out");
      setTimeout(() => {
        existing.style.display = "none";
      }, 600);
    }, 3000);
  }
}
