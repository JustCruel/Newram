document.getElementById('hamburger').addEventListener('click', function () {
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.getElementById('main-content');
    sidebar.classList.toggle('open');
    mainContent.classList.toggle('sidebar-open');  // Toggle the 'sidebar-open' class
});