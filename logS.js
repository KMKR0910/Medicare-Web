function validateForm() {
    // Get form elements by name
    let fname = document.forms["myForm"]["Fname"].value;
    let lname = document.forms["myForm"]["Lname"].value;
    let address = document.forms["myForm"]["address"].value;
    let contact = document.forms["myForm"]["contact"].value;
    let email = document.forms["myForm"]["email"].value;
    let password = document.forms["myForm"]["password"].value;
    let confirmPassword = document.forms["myForm"]["Cpass"].value;

    // Get company form elements
    let regNumber = document.forms["myForm"]["Creg"].value;
    let companyName = document.forms["myForm"]["Cname"].value;
    let companyContact = document.forms["myForm"]["Ccontact"].value;
    let companyAddress = document.forms["myForm"]["Caddress"].value;

    // Validate First Name
    if (fname == "") {
        alert("Please enter your first name.");
        return false;
    }

    // Validate Last Name
    if (lname == "") {
        alert("Please enter your last name.");
        return false;
    }

    // Validate Address
    if (address == "") {
        alert("Please enter your address.");
        return false;
    }

    // Validate Contact Number
    if (contact == "") {
        alert("Please enter your contact number.");
        return false;
    }

    // Validate Email
    if (email == "") {
        alert("Please enter your email.");
        return false;
    } else {
        // Basic email validation
        const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,6}$/;
        if (!email.match(emailPattern)) {
            alert("Please enter a valid email address.");
            return false;
        }
    }

    // Validate Password
    if (password == "") {
        alert("Please create a password.");
        return false;
    }

    // Validate Password Match
    if (password !== confirmPassword) {
        alert("Passwords do not match.");
        return false;
    }

    // Validate Company Registration Number
    if (regNumber == "") {
        alert("Please enter the company registration number.");
        return false;
    }

    // Validate Company Name
    if (companyName == "") {
        alert("Please enter the company name.");
        return false;
    }

    // Validate Company Contact Number
    if (companyContact == "") {
        alert("Please enter the company contact number.");
        return false;
    }

    // Validate Company Address
    if (companyAddress == "") {
        alert("Please enter the company address.");
        return false;
    }

    // If all validations pass
    alert("Form submitted successfully!");
   
    window.location.href ="dashboardS.html"; // Redirect to the dashboard
    
}
