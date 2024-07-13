document.addEventListener("DOMContentLoaded", () => {
  const profileForm = document.getElementById("profileForm");
  const deleteAccountBtn = document.getElementById("deleteAccountBtn");

  // Load user data when the page loads
  loadUserData();

  // Handle form submission
  profileForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      await updateUserProfile();
  });

  // Handle account deletion
  deleteAccountBtn.addEventListener("click", async () => {
      if (confirm("Are you sure you want to delete your account?")) {
          await deleteUserAccount();
      }
  });
});

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
          document.getElementById("username").value = data.user.username;
          document.getElementById("name").value = data.user.name;
          document.getElementById("email").value = data.user.email;
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
      formData.append("method", "updateUser");

      const response = await fetch("/api.php", {
          method: "POST",
          body: formData,
      });

      if (response.ok) {
          const data = await response.json();
          alert(data.message);
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
          body: JSON.stringify({ method: "deleteUser" }),
      });

      if (response.ok) {
          const data = await response.json();
          alert(data.message);
          if (data.status === "success") {
              window.location.href = "/logout";
          }
      } else {
          console.error("Failed to delete user account");
      }
  } catch (error) {
      console.error("Error:", error);
  }
}
