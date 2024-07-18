export class Modal {
  constructor(id) {
    this.id = id;
    this.modal = document.querySelector(id);
    this.closeButton = this.modal.querySelector(".btn-close");
    this.modalContent = this.modal.querySelector(".modal_content");

    this.closeButton.addEventListener("click", () => {
      this.hide();
    });

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
}
