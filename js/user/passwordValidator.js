(function() {
  const strongPassRegex = new RegExp(
    "^(((?=.*[a-z])(?=.*[A-Z]))((?=.*[A-Z])(?=.*[0-9])))(?=.*[!-._@#$%^&*]{1,})(?=.{10,})"
  );

  const lengthRegex = new RegExp(".{10}");
  const upperCaseRegex = new RegExp("[A-Z]");
  const lowerCaseRegex = new RegExp("[a-z]");
  const digitRegex = new RegExp("[0-9]");
  const specialCharRegex = new RegExp("[!-._@#$%^&*]");

  const passField = document.querySelector("input#pass");
  const passConfirmField = document.querySelector("input#passconfirm");

  const passStatusSpan = document.querySelector("span.pass-status");
  const passConfirmStatusSpan = document.querySelector("span.passconfirm-status");

  const lengthFeedbackSpan = document.querySelector("span#passLen");
  const uppercaseFeedbackSpan = document.querySelector("span#passUpper");
  const lowercaseFeedbackSpan = document.querySelector("span#passLower");
  const digitFeedbackSpan = document.querySelector("span#passDigit");
  const specialcharFeedbackSpan = document.querySelector("span#passSpecial");

  passField.addEventListener("keyup", handlePasswordKeyUp);
  passConfirmField.addEventListener("keyup", comparePasswords);

  function handlePasswordKeyUp(event) {
    const pass = passField.value;

    testPassword(pass, strongPassRegex, passStatusSpan);
    testPassword(pass, lengthRegex, lengthFeedbackSpan);
    testPassword(pass, lowerCaseRegex, lowercaseFeedbackSpan);
    testPassword(pass, upperCaseRegex, uppercaseFeedbackSpan);
    testPassword(pass, digitRegex, digitFeedbackSpan);
    testPassword(pass, specialCharRegex, specialcharFeedbackSpan);

    comparePasswords();

    function testPassword(pass, regex, feedbackElement) {
      if (regex.test(pass)) {
        setSpanAcceptable(feedbackElement);
      } else {
        setSpanRejected(feedbackElement);
      }

      function setSpanAcceptable(element) {
        element.className = "";
        element.classList.add("greenText", "bold");
        element.textContent = "ok";
      }

      function setSpanRejected(element) {
        element.className = "";
        element.classList.add("redText", "bold");
        element.textContent = "x";
      }
    }
  }

  function comparePasswords(event) {
    const pass = passField.value;
    const confirmedPass = passConfirmField.value;

    passConfirmStatusSpan.className = "";
    if (pass === confirmedPass && pass.length !== 0) {
      passConfirmStatusSpan.classList.add("greenText", "bold");
      passConfirmStatusSpan.textContent = "stämmer";
    } else {
      passConfirmStatusSpan.classList.add("redText", "bold");
      passConfirmStatusSpan.textContent = "stämmer inte";
    }
  }
})();
