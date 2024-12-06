function ValidateForm() {
    if (document.myform.email.value == "") {
      alert("Please enter your email");
      return false;
    }
    if (document.myform.password.value == "") {
      alert("Please enter your password");
      return false;
    }
    // Submit the form data to the PHP script
    document.myform.submit();
  }