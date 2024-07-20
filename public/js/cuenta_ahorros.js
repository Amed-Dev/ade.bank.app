import { $, $$ } from "./utils/dom.js";
function formatBalance() {
  $$(".balance-label").forEach((balance) => {
    let balance_amount = balance.getAttribute("data-balance");
    balance.textContent = new Intl.NumberFormat("es-PE", {
      style: "currency",
      currency: "PEN",
    }).format(balance_amount);
  });
}

function formatDate() {
  $$(".date-info").forEach((dataDate) => {
    let dateString = dataDate.getAttribute("data-date");
    const date = new Date(dateString.replace(" ", "T"));
    const options = {
      day: "numeric",
      month: "long",
      year: "numeric",
      hour: "2-digit",
      minute: "2-digit",
      hour12: true,
    };
    dataDate.textContent = new Intl.DateTimeFormat("es-ES", options).format(
      date
    );
  });
}
function copyToClipBoard() {
  $$("[data-toggle='copy-to-clipboard']").forEach((btn_copy) => {
    btn_copy.addEventListener("click", () => {
      let contentContainer = btn_copy.dataset.target;
      let contentElement = $(`${contentContainer}`);

      if (contentElement && navigator.clipboard) {
        let content = contentElement.textContent;
        navigator.clipboard
          .writeText(content)
          .then(() => showAlert("¡Copiado!", content, "success"))
          .catch((err) => {
            showAlert("¡Error al copiar!", err, "error");
            console.error("Error al copiar: ", err);
          });
      } else {
        showAlert("Error", "Clipboard API not supported or content not found.", "error");
      }
    });
  });
}



function showAlert(title, message, icon) {
  Swal.fire({
    title: title,
    text: message,
    icon: icon,
    confirmButtonText: "Aceptar",
  });
}
formatBalance();
formatDate();
copyToClipBoard();
