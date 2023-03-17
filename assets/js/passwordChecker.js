const profile_password_fields = document.getElementById('profile_password_fields');

if (profile_password_fields) {
  const password_first = document.getElementById('profile_plainPassword_first');
  const password_second = document.getElementById('profile_plainPassword_second');

  [password_first, password_second].forEach(input => input.addEventListener('keyup', (event) => {
    if (password_first.value.length >= 8 && password_second.value.length >= 8) {
      if ((password_first.value !== password_second.value)) {
        password_first.classList.add('border', 'border-red-500');
        password_second.classList.add('border', 'border-red-500');
        password_first.classList.remove('border-green-500');
        password_second.classList.remove('border-green-500');
      } else {
        password_first.classList.add('border', 'border-green-500');
        password_second.classList.add('border', 'border-green-500');
        password_first.classList.remove('border-red-500');
        password_second.classList.remove('border-red-500');
      }
    }
  }))
}