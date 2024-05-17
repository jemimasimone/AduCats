const genderSelect = document.getElementById('gender');
const registerForm = document.querySelector('form'); // Assuming your form has a tag

registerForm.addEventListener('submit', function(event) {
  const selectedGender = genderSelect.value;
  if (selectedGender === "") {
    event.preventDefault(); // Prevent form submission
    alert("Please select your gender.");
  }
});
