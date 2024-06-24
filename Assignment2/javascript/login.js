// Selecting necessary elements from the DOM
const form = document.querySelector(".login form"),
    continueBtn = form.querySelector(".button input"),
    errorText = form.querySelector(".error-text");

// Preventing the default form submission behavior
form.onsubmit = (e) => {
    e.preventDefault();
}

// Adding event listener to the continue button for click event
continueBtn.onclick = () => {
    // Creating an XMLHttpRequest object
    let xhr = new XMLHttpRequest();

    // Configuring the request to send a POST request to "php/login.php"
    xhr.open("POST", "php/login.php", true);

    // Adding a callback function to handle the request's onload event
    xhr.onload = () => {
        // Checking if the request is completed and successful (status code 200)
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            // Getting the response data from the server
            let data = xhr.response;

            // Checking if the login was successful ("success" response)
            if (data === "success") {
                // Redirecting the user to "users.php" upon successful login
                location.href = "users.php";
            } else {
                // Displaying an error message and updating the errorText element
                errorText.style.display = "block";
                errorText.textContent = data;
            }
        }
    }

    // Creating a FormData object from the form
    let formData = new FormData(form);

    // Sending the XMLHttpRequest with the form data
    xhr.send(formData);
}
