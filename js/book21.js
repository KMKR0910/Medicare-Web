function ValidateForm() {
    // Validate patient name
    if (document.myform.name.value === "") {
        alert("Please enter the patient name.");
        return false;
    }

    // Validate contact number (10 digits)
    var contactNumber = document.myform.conta.value;
    var phonePattern = /^\d{10}$/; // Regular expression for 10 digits

    if (contactNumber === "") {
        alert("Please enter contact info.");
        return false;
    } else if (!contactNumber.match(phonePattern)) {
        alert("Please enter a valid 10-digit phone number.");
        return false;
    }

    // Validate appointment date
    var appointmentDate = new Date(document.myform.app_date.value);
    var today = new Date();
    var nextWeek = new Date();
    nextWeek.setDate(today.getDate() + 7); // Set to 7 days from today

    if (document.myform.app_date.value === "") {
        alert("Please select an appointment date.");
        return false;
    } else if (appointmentDate < today || appointmentDate > nextWeek) {
        alert("Please select a date within the next week.");
        return false;
    }

    // Validate appointment number
    

    // Validate appointment time
    if (document.myform.app_time.value === "") {
        alert("Please select an appointment time.");
        return false;
    }

    // If all fields are valid, return true
    return true;
}
 
 
