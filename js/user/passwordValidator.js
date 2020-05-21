(function() {
  const strongPassRegex = new RegExp(
    "^(((?=.*[a-z])(?=.*[A-Z]))((?=.*[A-Z])(?=.*[0-9])))(?=.*[!-._@#$%^&*]{1,})(?=.{8,})"
  );
  const mediumPassRegex = new RegExp(
    "^(((?=.*[a-z])(?=.*[A-Z]))|((?=.*[a-z])(?=.*[0-9]))|((?=.*[A-Z])(?=.*[0-9])))(?=.{6,})"
  );

  const passField = document.querySelector("input#pass");
  const passConfirmField = document.querySelector("input#passconfirm");
  const passStatusSpan = document.querySelector("span.pass-status");
  const passConfirmStatusSpan = document.querySelector("span.passconfirm-status");

  passField.addEventListener("keyup", handlePasswordKeyUp);
  passConfirmField.addEventListener("keyup", comparePasswords);

  function handlePasswordKeyUp(event) {
    const pass = passField.value;
    if (strongPassRegex.test(pass)) {
      passStatusSpan.className = "";
      passStatusSpan.classList.add("greenText", "bold");
      passStatusSpan.textContent = "starkt";
    } else if (mediumPassRegex.test(pass)) {
      passStatusSpan.className = "";
      passStatusSpan.classList.add("orangeText", "bold");
      passStatusSpan.textContent = "svagt";
    } else {
      passStatusSpan.className = "";
      passStatusSpan.classList.add("redText", "bold");
      passStatusSpan.textContent = "svagt";
    }
    comparePasswords();
  }

  function comparePasswords(event) {
    const pass = passField.value;
    const confirmedPass = passConfirmField.value;
    if (pass === confirmedPass && pass.length !== 0) {
      passConfirmStatusSpan.className = "";
      passConfirmStatusSpan.classList.add("greenText", "bold");
      passConfirmStatusSpan.textContent = "stämmer";
    } else {
      passConfirmStatusSpan.className = "";
      passConfirmStatusSpan.classList.add("redText", "bold");
      passConfirmStatusSpan.textContent = "stämmer inte";
    }
  }
})();
