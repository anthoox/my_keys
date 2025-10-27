
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
});
