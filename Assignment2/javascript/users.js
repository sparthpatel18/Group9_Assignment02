// Selecting necessary elements from the DOM
const searchBar = document.querySelector(".search input"),
    searchIcon = document.querySelector(".search button"),
    usersList = document.querySelector(".users-list");

// Adding click event listener to the search icon
searchIcon.onclick = () => {
    // Toggling the visibility of the search bar
    searchBar.classList.toggle("show");

    // Toggling the "active" class on the search icon for styling
    searchIcon.classList.toggle("active");

    // Focusing on the search bar
    searchBar.focus();

    // Clearing the search bar value if it was previously active
    if (searchBar.classList.contains("active")) {
        searchBar.value = "";
        searchBar.classList.remove("active");
    }
}

// Adding keyup event listener to the search bar for real-time search
searchBar.onkeyup = () => {
    // Getting the search term from the search bar value
    let searchTerm = searchBar.value;

    // Adding or removing the "active" class based on whether the search term is empty
    if (searchTerm !== "") {
        searchBar.classList.add("active");
    } else {
        searchBar.classList.remove("active");
    }

    // Creating an XMLHttpRequest object for sending a search request
    let xhr = new XMLHttpRequest();

    // Configuring the request to send a POST request to "php/search.php"
    xhr.open("POST", "php/search.php", true);

    // Adding a callback function to handle the request's onload event
    xhr.onload = () => {
        // Checking if the request is completed and successful (status code 200)
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            // Getting the response data from the server and updating the usersList
            let data = xhr.response;
            usersList.innerHTML = data;
        }
    }

    // Setting the request header for form data
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    // Sending the XMLHttpRequest with the search term as form data
    xhr.send("searchTerm=" + searchTerm);
}

// Setting up an interval for fetching and updating the users list every 500 milliseconds
setInterval(() => {
    // Creating an XMLHttpRequest object for fetching the users list
    let xhr = new XMLHttpRequest();

    // Configuring the request to send a GET request to "php/users.php"
    xhr.open("GET", "php/users.php", true);

    // Adding a callback function to handle the request's onload event
    xhr.onload = () => {
        // Checking if the request is completed and successful (status code 200)
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            // Getting the response data from the server
            let data = xhr.response;

            // Updating the usersList only if the search bar is not active
            if (!searchBar.classList.contains("active")) {
                usersList.innerHTML = data;
            }
        }
    }

    // Sending the XMLHttpRequest for fetching the users list
    xhr.send();
}, 500);
