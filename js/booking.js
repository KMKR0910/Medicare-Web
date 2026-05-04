function ValidateForm() {
    if (document.myform.name.value == "") {
      alert("Please enter your name");
      return false;
    }
    if (document.myform.contact.value == "") {
      alert("Please enter your contact details");
      return false;
    }
    if (document.myform.email.value == "") {
      alert("Please enter your Gmail");
      return false;
    }
    if (document.myform.password.value == "") {
      alert("Please enter your password");
      return false;
    }
  return true;
  }
  function checkSignInStatus() {
    const signedIn = localStorage.getItem('signedIn');
    if (signedIn !== 'true') {
        // If not signed in, redirect to the sign-in page
        alert('You must sign in to access the booking page.');
        window.location.href = 'logP.html';
    }
}

window.onload = checkSignInStatus; // Check sign-in status when the page loads

  
  
  