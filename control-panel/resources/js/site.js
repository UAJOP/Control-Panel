function animate(element) {
    element.classList.add('disable-animation');
    setTimeout(function () {
        element.classList.remove('disable-animation');
    }, 10);
}


async function getSessionUser() {
    try {
        let response = await fetch('/api/user/get-user-from-session.php');
        let data = await response.json();
        return data;
    } catch (error) {
        return null;
    }
}


async function getProfilePicture(username) {
    var response = await fetch('api/user/get-image.php?username=' + username);
    if (response.status === 404) {
        return 'resources/img/empty_pfp.png';
    }

    return response.text();
}


async function logout() {
    let response = await fetch('/api/user/logout.php', {
        method: 'POST'
    });
    return response;
}



async function getDashboardInfo() {
    var result = await fetch("api/dashboard.php", {
        method: "POST"
    });
    return result.json();
}

async function getUsers() {
    var result = await fetch("api/user/read.php", {
        method: "GET"
    });
    return result.json();
}

async function getProducts() {
    var result = await fetch("api/product/read.php", {
        method: "GET"
    });
    return result.json();
}

async function getRoles() {
    var result = await fetch("api/role/read.php", {
        method: "GET"
    });
    return result.json();
}

async function getProductCategories() {
    var result = await fetch("api/category/read.php", {
        method: "GET"
    });
    return result.json();
}

async function changeShownDatatable(name) {
    var tables = document.getElementsByClassName("data-table");
    for (var i = 0; i < tables.length; i++) {
        tables[i].classList.add("hidden");
    }
    document.querySelector(".data-table[for='" + name + "']").classList.remove("hidden");
}


function openModal(modal) {
    modal = document.getElementById(modal);
    modal.classList.add("show");
}

function closeModal(modal) {
    modal = document.getElementById(modal);
    modal.classList.remove("show");
}

async function createUser(data) {
    var result = await fetch("api/user/create.php", {
        method: "POST",
        body: JSON.stringify(data)
    });
    return result.json();
}

async function updateUser(data) {
    var result = await fetch("api/user/update.php", {
        method: "POST",
        body: JSON.stringify(data)
    });
    return result.json();
}

async function deleteUser(data) {
    var result = await fetch("api/user/delete.php?id=" + data.id, {
        method: "DELETE",
    });
    return result.json();
}

async function createProduct(data) {
    var result = await fetch("api/product/create.php", {
        method: "POST",
        body: JSON.stringify(data)
    });
    return result.json();
}

async function updateProduct(data) {
    var result = await fetch("api/product/update.php", {
        method: "POST",
        body: JSON.stringify(data)
    });
    return result.json();
}

async function deleteProduct(data) {
    var result = await fetch("api/product/delete.php?id=" + data.id, {
        method: "DELETE"
    });
    return result.json();
}
