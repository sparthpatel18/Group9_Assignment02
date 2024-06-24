// Selecting necessary elements from the DOM
const pswrdField = document.querySelector(".form input[type='password']"),
    toggleIcon = document.querySelector(".form .field i");

// Adding event listener to the toggle icon for click event
toggleIcon.onclick = () => {
  // Checking the current type of the password field
  if (pswrdField.type === "password") {
    // If the password field is of type "password", change it to "text"
    pswrdField.type = "text";

    // Adding the "active" class to the toggle icon for styling
    toggleIcon.classList.add("active");
  } else {
    // If the password field is of type "text", change it back to "password"
    pswrdField.type = "password";

    // Removing the "active" class from the toggle icon
    toggleIcon.classList.remove("active");
  }
}
