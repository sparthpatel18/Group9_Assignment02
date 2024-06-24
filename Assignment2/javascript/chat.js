// Selecting necessary elements from the DOM
const form = document.querySelector(".typing-area"),
    incoming_id = form.querySelector(".incoming_id").value,
    inputField = form.querySelector(".input-field"),
    sendBtn = form.querySelector("button"),
    chatBox = document.querySelector(".chat-box");

// Preventing the default form submission behavior
form.onsubmit = (e) => {
    e.preventDefault();
}

// Setting focus on the input field when the page loads
inputField.focus();

// Adding event listener to the input field for keyup event
inputField.onkeyup = () => {
    // Adding or removing the "active" class based on the input field value
    if (inputField.value !== "") {
        sendBtn.classList.add("active");
    } else {
        sendBtn.classList.remove("active");
    }
}

// Adding event listener to the send button for click event
sendBtn.onclick = () => {
    // Creating an XMLHttpRequest object
    let xhr = new XMLHttpRequest();

    // Configuring the request to send a POST request to "php/insert-chat.php"
    xhr.open("POST", "php/insert-chat.php", true);

    // Adding a callback function to handle the request's onload event
    xhr.onload = () => {
        // Checking if the request is completed and successful (status code 200)
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            // Clearing the input field and scrolling to the bottom of the chat box
            inputField.value = "";
            scrollToBottom();
        }
    }

    // Creating a FormData object from the form
    let formData = new FormData(form);

    // Sending the XMLHttpRequest with the form data
    xhr.send(formData);
}

// Adding event listeners to the chat box for mouseenter and mouseleave events
chatBox.onmouseenter = () => {
    chatBox.classList.add("active");
}

chatBox.onmouseleave = () => {
    chatBox.classList.remove("active");
}

// Setting up a periodic function using setInterval for updating the chat
setInterval(() => {
    // Creating an XMLHttpRequest object
    let xhr = new XMLHttpRequest();

    // Configuring the request to send a POST request to "php/get-chat.php"
    xhr.open("POST", "php/get-chat.php", true);

    // Adding a callback function to handle the request's onload event
    xhr.onload = () => {
        // Checking if the request is completed and successful (status code 200)
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            // Updating the chat box with the response data
            let data = xhr.response;
            chatBox.innerHTML = data;

            // Scrolling to the bottom of the chat box if it is not in the active state
            if (!chatBox.classList.contains("active")) {
                scrollToBottom();
            }
        }
    }

    // Setting the request header
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    // Sending the XMLHttpRequest with the incoming_id parameter
    xhr.send("incoming_id=" + incoming_id);
}, 500);

// Function to scroll to the bottom of the chat box
function scrollToBottom() {
    chatBox.scrollTop = chatBox.scrollHeight;
}
