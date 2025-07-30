  // Toggle menu mobile
  const menuToggle = document.getElementById('menu-toggle');
  const sidebar = document.getElementById('sidebar');
  menuToggle.addEventListener('click', () => {
    sidebar.classList.toggle('active');
  });

  // Toggle dropdown do perfil
  const userProfile = document.getElementById('user-profile');
  const profileDropdown = document.getElementById('profile-dropdown');
  userProfile.addEventListener('click', () => {
    profileDropdown.classList.toggle('active');
  });

  // Fecha dropdown clicando fora
  document.addEventListener('click', (e) => {
    if (!userProfile.contains(e.target)) {
      profileDropdown.classList.remove('active');
    }
  });