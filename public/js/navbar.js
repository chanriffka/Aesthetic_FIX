const currentLocation = window.location.href;
        const menuItems = document.querySelectorAll('.nav-item a');

        menuItems.forEach(item => {
            if (item.href === currentLocation || currentLocation.startsWith(item.href)) {
                item.parentElement.classList.add('navbar-active');
            }
        });