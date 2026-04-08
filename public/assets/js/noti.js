const noti = document.getElementById('notification');
const dropdown = document.getElementById('dropdown');

noti.addEventListener('click', function (e) {
    e.stopPropagation();
    dropdown.classList.toggle('show');
});

document.addEventListener('click', function (e) {
    if (!dropdown.contains(e.target) && !noti.contains(e.target)) {
        dropdown.classList.remove('show');
    }
});

const notidesk = document.getElementById('notification-desktop');
const dropdowndesk = document.getElementById('dropdown-desktop');

notidesk.addEventListener('click', function (e) {
    e.stopPropagation();
    dropdowndesk.classList.toggle('show');
});

document.addEventListener('click', function (e) {
    if (!dropdowndesk.contains(e.target) && !notidesk.contains(e.target)) {
        dropdowndesk.classList.remove('show');
    }
});


