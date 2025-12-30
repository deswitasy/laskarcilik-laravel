function validateForm(formId) {
  const form = document.getElementById(formId);
  if (!form) return true;

  const requiredFields = form.querySelectorAll('[required]');
  let isValid = true;

  requiredFields.forEach(field => {
    if (!field.value.trim()) {
      field.style.borderColor = 'red';
      isValid = false;
    } else {
      field.style.borderColor = '#ddd';
    }
  });

  if (!isValid) {
    alert('Mohon lengkapi semua field yang wajib diisi!');
  }

  return isValid;
}

document.addEventListener('DOMContentLoaded', function() {
  const inputs = document.querySelectorAll('input, select, textarea');
  
  inputs.forEach(input => {
    input.addEventListener('input', function() {
      if (this.style.borderColor === 'red') {
        this.style.borderColor = '#ddd';
      }
    });
  });
});