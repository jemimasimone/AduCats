const genderSelect = document.getElementById('role');
const registerForm = document.querySelector('form'); // Assuming your form has a tag

registerForm.addEventListener('submit', function(event) {
  const selectedGender = genderSelect.value;
  if (selectedGender === "") {
    event.preventDefault(); // Prevent form submission
    alert("Please select your role.");
  }
});

document.getElementById('role').addEventListener('change', function() {
  if (this.value) {
      this.style.color = 'black';
  } else {
      this.style.color = '#757575'; // default color for the placeholder
  }
});

