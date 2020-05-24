(function() {
  const editUserDiv = document.querySelector("div#edit-user-div");

  const userDetailsDiv = document.querySelector("div#user-details-div");

  const editUserInfoBtn = document.querySelector("button#editUserDetailsButton");
  editUserInfoBtn.addEventListener("click", function() {
    userDetailsDiv.classList.add("hidden");
    editUserDiv.classList.remove("hidden");
  });

  const cancelEditBtn = document.querySelector("button.cancel-edit-btn");
  cancelEditBtn.addEventListener("click", function() {
    editUserDiv.classList.add("hidden");
    userDetailsDiv.classList.remove("hidden");
  });
})();
