document.addEventListener("DOMContentLoaded", function() {
    const logoutLink = document.querySelector(".logout a");

    logoutLink.addEventListener("click", function(event) {
        event.preventDefault(); // Prevent the default link behavior
        const confirmLogout = confirm("Are you sure you want to exit?");
        
        if (confirmLogout) {
            // Redirect to the logout page if the user clicks "Yes"
            window.location.href = this.href;
        }
    });
});
