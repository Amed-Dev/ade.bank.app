export function showAlert(title, message, icon) {
  Swal.fire({
    title: title,
    text: message,
    icon: icon,
    confirmButtonText: "Aceptar",
  });
}
