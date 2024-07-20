import { $, $$ } from "./utils/dom.js";
import { Modal } from "./components/modal/modal.js";

var formulario_transfer = document.getElementById("form-transfermoney");
var formulario_paySevices = document.getElementById("form-payServices");
const messageTransfer = $("#messageTransfer");
const messageService = $("#messageServices");

hideLoading();
formulario_transfer.addEventListener("submit", (e) => {
  e.preventDefault();

  transfermoney();
});

formulario_paySevices.addEventListener("submit", (e) => {
  e.preventDefault();

  payServices();
});

function showLoading() {
  var loader = document.getElementById("loader");
  var content = document.getElementById("transfer");

  var amount = document.getElementById("amount");
  var accountnumber = document.getElementById("accountnumber");
  loader.style.display = "block";
  amount.disabled = true;
  accountnumber.disabled = true;
}
function hideLoading() {
  var loader = document.getElementById("loader");
  loader.style.display = "none";
  amount.disabled = false;
  accountnumber.disabled = false;
}

function formatBalance() {
  $$(".balance-label").forEach((balance) => {
    let balance_amount = balance.getAttribute("data-balance");
    balance.textContent = new Intl.NumberFormat("es-PE", {
      style: "currency",
      currency: "PEN",
    }).format(balance_amount);
  });
}
formatBalance();
async function payServices() {
  try {
    const formData = new FormData($("#form-payServices"));
    showLoading();
    formData.append("method", "payServices");
    formData.append("transaction", "payServices");
    const url = "/api.php";
    const response = await fetch(url, {
      method: "POST",
      body: formData,
    });

    if (response.ok) {
      const data = await response.json();

      if (data.status === "failed") {
        messageService.classList.remove("error", "success");
        messageService.classList.add("error");
        messageService.textContent = data.message;
      } else if (data.status === "success") {
        messageService.classList.remove("error", "success");
        messageService.classList.add("success");
        messageService.textContent = data.message;
        setTimeout(() => {
          window.location.href = "/dashboard";
        }, 3000);
      }
    }
    setTimeout(hideLoading(), 3000);
  } catch (error) {
    console.error(`Error while loading data: ${error}`);
  }
}

async function transfermoney() {
  try {
    const formData = new FormData($("#form-transfermoney"));
    showLoading();
    formData.append("method", "transfermoney");
    formData.append("transaction", "transfer");
    formData.append("destination", "destination account");
    const url = "/api.php";
    const response = await fetch(url, {
      method: "POST",
      body: formData,
    });

    if (response.ok) {
      const data = await response.json();

      if (data.status === "failed") {
        messageTransfer.classList.remove("error", "success");
        messageTransfer.classList.add("error");
        messageTransfer.textContent = data.message;
      } else if (data.status === "success") {
        messageTransfer.classList.remove("error", "success");
        messageTransfer.classList.add("success");
        messageTransfer.textContent = data.message;
        setTimeout(() => {
          window.location.href = "/dashboard";
        }, 3000);
      }
    }
    setTimeout(hideLoading(), 3000);
  } catch (error) {
    console.error(`Error while loading data: ${error}`);
  }
}

document.querySelectorAll("[data-toggle='modal']").forEach((triggerButton) => {
  const modalElement = document.querySelector(triggerButton.dataset.target);
  if (modalElement) {
    const modalInstance = new Modal(modalElement);

    triggerButton.addEventListener("click", () => {
      modalInstance.show();
    });

    modalElement
      .querySelectorAll("[data-dismiss='modal']")
      .forEach((btnCancel) => {
        btnCancel.addEventListener("click", () => {
          modalInstance.hide();
        });
      });
  }
});
