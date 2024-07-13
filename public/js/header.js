import { $ } from "./utils/dom.js";

const user = async () => {
  try {
    const url = "/api.php";
    const response = await fetch(url, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        method: "getDataUser",
      }),
    });

    if (response.ok) {
      const data = await response.json();
      return data.user;
    } else {
      const errorData = await response.json();
      console.error("Error:", errorData);
      return null;
    }
  } catch (error) {
    console.error(`Error loading data: ${error}`);
    return null;
  }
};

document.addEventListener("DOMContentLoaded", async () => {
  const dropdownBtn = document.getElementById("dropdownBtn");
  const dropdownContent = document.querySelector(".dropdown-content");
  const profile_btn = document.querySelector("#profile_view");

  if (dropdownBtn) {
    dropdownBtn.addEventListener("click", () => {
      dropdownContent.classList.toggle("show");
    });

    window.addEventListener("click", (event) => {
      if (
        !event.target.matches("#dropdownBtn") &&
        !event.target.closest(".dropdown-btn")
      ) {
        if (dropdownContent.classList.contains("show")) {
          dropdownContent.classList.remove("show");
        }
      }
    });
  }

  const burgerMenu = document.querySelector(".burger-menu");
  const navMenu = document.querySelector(".nav-menu");

  if (burgerMenu && navMenu) {
    burgerMenu.addEventListener("click", () => {
      burgerMenu.classList.toggle("active");
      navMenu.classList.toggle("active");
    });
  }

  // Obtener el nombre del usuario y actualizar el header
  const userData = await user();
  if (userData) {
    const username = userData.Name;
    // responsive_header(username);
    $(".profile-info-name").textContent = username;   

    profile_btn.setAttribute("href", `/user/${userData.Username}`);
  } else {
    console.error("Failed to load user data.");
  }
});


