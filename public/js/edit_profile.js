import { $, $$ } from "./utils/dom.js";
import { Modal } from "./components/modal/modal.js";
import { PasswordToggle } from "./components/password_toggle/PasswordToggle.js";
import { PasswordValidator } from "./components/password_validation/Password_Validation.js";

function initPasswordToggles() {
  const passwordToggles = $$("[data-toggle='input_password']");

  passwordToggles.forEach((toggle) => {
    const passwordInputId = toggle.dataset.target;
    new PasswordToggle(passwordInputId);
  });
}

document.addEventListener("DOMContentLoaded", () => {
  new PasswordValidator("#new_password", "#btn_Update_password", false);

  const profileForm = document.getElementById("profileForm");
  const deleteAccountBtn = document.getElementById("deleteAccountBtn");
  const passwordUpdateForm = $("#password_change_form");
  const btnCancel = $("#btn_cancel");

  passwordUpdateForm.addEventListener("submit", async function (e) {
    e.preventDefault();
    const updatePasswordResponse = await updatePasswordUser(this);

    if (updatePasswordResponse.status === "success") {
      showAlert(
        "¡Actualización de contraseña exitosa!",
        updatePasswordResponse.message,
        updatePasswordResponse.status
      );
      loadUserData();
      const modal = new Modal("#change_password");
      modal.hide();
      this.reset();
    } else {
      showAlert(
        "¡Algo Salio Mal!",
        updatePasswordResponse.message,
        updatePasswordResponse.status
      );
    }
  });
  // Load user data when the page loads
  loadUserData();

  // Handle form submission
  profileForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    const updateResponse = await updateUserProfile();

    if (updateResponse.status === "success") {
      showAlert(
        "¡Actualización exitosa!",
        updateResponse.message,
        updateResponse.status
      );
      loadUserData();
      $(".profile-info-name").textContent = updateResponse.user;
      $$("image-abbr").forEach((abbr) => {
        abbr.setAttribute("text", updateResponse.user);
      });
    } else {
      showAlert(
        "¡Algo Salio Mal!",
        updateResponse.message,
        updateResponse.status
      );
    }
  });

  deleteAccountBtn.addEventListener("click", async (e) => {
    const deleteResponse = await deleteUserAccount();
    if (deleteResponse.status === "success") {
      showAlert(
        "!Cuenta eliminada exitosamente!",
        deleteResponse.message,
        deleteResponse.status
      );
      window.location.href = "/logout";
    } else {
      showAlert(
        "¡Algo Salio Mal!",
        updateResponse.message,
        updateResponse.status
      );
    }
  });

  const modalButtons = $$('[data-toggle="modal"]');
  const modals = {};

  modalButtons.forEach((btn) => {
    const modalId = btn.dataset.target;
    const modal = new Modal(modalId);
    modals[modalId] = modal;

    btnCancel.addEventListener("click", () => {
      modal.hide();
    });
    btn.addEventListener("click", () => {
      modal.show();
    });
  });
  initPasswordToggles();
});

function showAlert(title, message, icon) {
  Swal.fire({
    title: title,
    text: message,
    icon: icon,
    confirmButtonText: "Aceptar",
  });
}

async function loadUserData() {
  try {
    const response = await fetch("/api.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ method: "getUser" }),
    });

    if (response.ok) {
      const data = await response.json();
      document.getElementById("username").value = data.user.Username;
      document.getElementById("name").value = data.user.Name;
      document.getElementById("last_name").value = data.user.Last_name;
      document.getElementById("email").value = data.user.Email;
    } else {
      console.error("Failed to load user data");
    }
  } catch (error) {
    console.error("Error:", error);
  }
}

async function updateUserProfile() {
  try {
    const formData = new FormData(document.getElementById("profileForm"));
    formData.append("username", document.getElementById("username").value);
    formData.append("method", "updateUser");

    const response = await fetch("/api.php", {
      method: "POST",
      body: formData,
    });

    if (response.ok) {
      const data = await response.json();
      return data;
    } else {
      console.error("Failed to update user profile");
    }
  } catch (error) {
    console.error("Error:", error);
  }
}

async function deleteUserAccount() {
  try {
    const response = await fetch("/api.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ method: "deleteAccount" }),
    });

    if (response.ok) {
      const data = await response.json();
      return data;
    } else {
      console.error("Failed to delete user account");
    }
  } catch (error) {
    console.error("Error:", error);
  }
}

async function updatePasswordUser(formSelector) {
  try {
    const formData = new FormData(formSelector);
    formData.append("method", "updateUserPassword");
    const response = await fetch("/api.php", {
      method: "POST",
      body: formData,
    });
    if (response.ok) {
      const data = await response.json();
      return data;
    } else {
      console.error("Failed to update user password");
    }
  } catch (error) {
    console.error(`Error while changing password: ${error}`);
  }
}
