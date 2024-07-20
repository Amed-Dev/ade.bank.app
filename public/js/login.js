import { $ } from "./utils/dom.js";
import { showAlert } from "./utils/alert.js";
import { PasswordToggle } from "./components/password_toggle/PasswordToggle.js";

//Ejecutando funciones
$("#btn__registrarse").addEventListener("click", register);
window.addEventListener("resize", anchoPage);

//Declarando variables
const password_toggle_view = new PasswordToggle("#password_login");

const message = $("#message");
var formulario_login = document.querySelector(".formulario__login");
var contenedor_login_register = document.querySelector(
  ".contenedor__login-register"
);
var caja_trasera_register = document.querySelector(".caja__trasera-register");

//FUNCIONES

function anchoPage() {
  if (window.innerWidth > 850) {
    caja_trasera_register.style.display = "block";
  } else {
    caja_trasera_register.style.display = "block";
    caja_trasera_register.style.opacity = "1";
    formulario_login.style.display = "block";
    contenedor_login_register.style.left = "0px";
  }
}

anchoPage();

function register() {
  window.location.href = "/register";
}

formulario_login.addEventListener("submit", (e) => {
  e.preventDefault();
  login();
});

async function login() {
  try {
    const formData = new FormData($("#login-form"));
    formData.append("method", "login");
    const url = "/api.php";
    const response = await fetch(url, {
      method: "POST",
      body: formData,
    });

    if (response.ok) {
      const data = await response.json();

      if (data.status === "failed") {
        message.classList.remove("error", "success");
        message.classList.add("error");
        message.textContent = data.message;
      } else if (data.status === "success") {
        showAlert("¡Inicio de sesión exitoso!", data.message, data.status);
        setTimeout(() => {
          window.location.href = "/dashboard";
        }, 3000);
      }
    }
  } catch (error) {
    console.error(`Error while loading data: ${error}`);
  }
}
