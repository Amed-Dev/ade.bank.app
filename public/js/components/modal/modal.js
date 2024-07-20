export class Modal {
  constructor(modalElement) {
    this.modal = modalElement;
    this.closeButton = this.modal.querySelector(".btn-close");
    this.modalContent = this.modal.querySelector(".modal_content");

    // Add event listener for close button
    if (this.closeButton) {
      this.closeButton.addEventListener("click", () => {
        this.hide();
      });
    }

    // Add event listener to hide modal when clicking outside of it
    this.modal.addEventListener("click", (e) => {
      if (e.target === this.modal) {
        this.hide();
      }
    });
  }

  show() {
    this.modal.style.display = "block";
  }

  hide() {
    this.modal.style.display = "none";
  }

  // Method to allow custom actions before hiding the modal
  setActionButton(selector, callback) {
    const actionButton = this.modal.querySelector(selector);
    if (actionButton) {
      actionButton.addEventListener("click", async (event) => {
        await callback(event);
        this.hide();
      });
    }
  }
}
