function minimizeAside() {
    let cookies = Object.fromEntries(document.cookie.split('; ').map(function (v) {
        return v.split(/=(.*)/s).map(decodeURIComponent);
    }));

    let body = document.getElementById('kt_body');

    if (cookies.kt_aside_toggle_state === 'on') {
        body.classList.add('aside-minimize');
    } else {
        body.classList.remove('aside-minimize');
    }
}

minimizeAside();
