require('./bootstrap');

require('alpinejs');

window.Echo.private('App.Models.User.' + userId)
    .notification(function (data) {
        var toast = new bootstrap.Toast(document.getElementById('notifcationToast'))

        document.getElementById('notifcation-title').innerHTML = data.title
        document.getElementById('notifcation-body').innerHTML = data.body
        document.getElementById('notifcation-time').innerHTML = new Date()

        toast.show()

        const countElm = document.getElementById('nm-count');
        let count = Number(countElm.innerText)
        countElm.innerText = count + 1;

        const listElm = document.getElementById('nm-list');
        listElm.innerHTML = `<li><a class="dropdown-item" href="${data.url}?notify_id=${data.id}">
            <h6>${data.title}</h6>
            <p>${data.body}</p>
            <p class="text-muted">${(new Date).toLocaleTimeString()}</p>
        </a></li>` + listElm.innerHTML;
    });
