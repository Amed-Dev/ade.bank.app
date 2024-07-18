export class PasswordValidator {
  constructor(passwordSelector, buttonSelector, allowEmptyPassword) {
    this.digitPattern = /\d/;
    this.lowerCasePattern = /[a-z]/;
    this.upperCasePattern = /[A-Z]/;
    this.specialCharacterPattern =
      /[\!\@\#\$\%\^\&\*\)\(\+\=\.\<\>\{\}\[\]\:\;\'\"\|\~\`\_\-\?\,\/\\]/;

    this.rules = [
      {
        field: document.querySelector(".password-length"),
        validation: (password) => password.length >= 8,
        result: false,
      },
      {
        field: document.querySelector(".password-digit"),
        validation: (password) => this.digitPattern.test(password),
        result: false,
      },
      {
        field: document.querySelector(".password-lower-case"),
        validation: (password) => this.lowerCasePattern.test(password),
        result: false,
      },
      {
        field: document.querySelector(".password-upper-case"),
        validation: (password) => this.upperCasePattern.test(password),
        result: false,
      },
      {
        field: document.querySelector(".password-special-character"),
        validation: (password) => this.specialCharacterPattern.test(password),
        result: false,
      },
    ];

    this.password = document.querySelector(passwordSelector);
    this.passwordConfirmation = document.querySelector("#passwordConfirmation");
    this.passwordsNotMatchError = document.querySelector(
      ".passwords-not-match"
    );
    this.passwordsMatchCheck = document.querySelector(".passwords-match");
    this.buttonSubmit = document.querySelector(buttonSelector);
    this.shouldAllowEmptyPassword = allowEmptyPassword;

    this.password.addEventListener("keyup", this.validate.bind(this));
    this.passwordConfirmation.addEventListener(
      "keyup",
      this.validateConfirmation.bind(this)
    );
    this.password
      .closest("form")
      .addEventListener("submit", this.passwordsMatch.bind(this));
  }

  validate() {
    const password = this.password.value;
    this.rules.forEach((rule) => {
      const isValid = rule.validation(password);
      rule.result = isValid;
      if (isValid) {
        rule.field.classList.add("check");
      } else {
        rule.field.classList.remove("check");
      }
    });
    this.toggleButton();
  }

  validateConfirmation() {
    const password = this.password.value;
    const confirmPassword = this.passwordConfirmation.value;
    if (password === confirmPassword) {
      this.passwordsMatchCheck.classList.add("--check-show");
      this.passwordsNotMatchError.classList.remove("--error-show");
    } else {
      this.passwordsMatchCheck.classList.remove("--check-show");
      this.passwordsNotMatchError.classList.add("--error-show");
    }
    this.toggleButton();
  }

  toggleButton() {
    const allValid = this.rules.every((rule) => rule.result);
    const passwordsMatch =
      this.password.value === this.passwordConfirmation.value;
    if ((allValid && passwordsMatch) || this.shouldEnableButtonSubmit()) {
      this.buttonSubmit.disabled = false;
    } else {
      this.buttonSubmit.disabled = true;
    }
  }

  shouldEnableButtonSubmit() {
    return this.shouldAllowEmptyPassword && this.password.value.length === 0;
  }

  passwordsMatch(event) {
    const password = this.password.value;
    const confirmPassword = this.passwordConfirmation.value;
    if (confirmPassword.length > 0 && password !== confirmPassword) {
      this.passwordsNotMatchError.classList.add("--error-show");
      event.preventDefault();
    } else {
      this.passwordsNotMatchError.classList.remove("--error-show");
    }
  }
}
