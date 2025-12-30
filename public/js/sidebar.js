const sidebar = document.getElementById('sidebar');
const mainContent = document.getElementById('mainContent');
const sidebarTab = document.getElementById('sidebarTab');
const closeBtn = document.getElementById('sidebarCloseBtn');

closeBtn.onclick = () => {
    sidebar.classList.add('closed');
    mainContent.classList.add('expanded');
    sidebarTab.classList.add('show');
};

sidebarTab.onclick = () => {
    sidebar.classList.remove('closed');
    mainContent.classList.remove('expanded');
    sidebarTab.classList.remove('show');
};
