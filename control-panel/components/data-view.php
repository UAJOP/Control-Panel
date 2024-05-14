<div class="tab-list">
    <div class="tab" id="userTab" onclick="changeShownDatatable('userTab')">Kullanıcılar</div>
    <div class="tab" id="productTab" onclick="changeShownDatatable('productTab')">Ürünler</div>
</div>
<div class="data-table" for="userTab">
    <h1>Kullanıcılar</h1>
    <table>
        <thead>
        <tr>
            <th class="add-action"><i class="fas fa-plus" onclick="openModal('userCreateModal')"></i></th>
            <th>Kullanıcı adı</th>
            <th>Email</th>
            <th>Ad</th>
            <th>Soyad</th>
            <th>Adres</th>
            <th>Rol</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

<div class="data-table hidden" for="productTab">
    <h1>Ürünler</h1>
    <table>
        <thead>
        <tr>
            <th class="add-action"><i class="fas fa-plus" onclick="openModal('productCreateModal')"></i></th>
            <th>Ad</th>
            <th>Tanıtım</th>
            <th>Alış Fiyatı</th>
            <th>Satış Fiyatı</th>
            <th>Kategori</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

<div class="modal" id="userCreateModal">
    <i class="closeModal fas fa-times" onclick="closeModal('userCreateModal')"></i>
    <h5>Create User</h5>
    <form>
        <input type="text" name="username" placeholder="Kullanıcı adı">
        <input type="text" name="email" placeholder="Email">
        <input type="text" name="first_name" placeholder="Ad">
        <input type="text" name="last_name" placeholder="Soyad">
        <input type="text" name="full_address" placeholder="Adres">
        <select name="role">
        </select>
        <input type="password" name="password" placeholder="Şifre">
        <button type="submit">Oluştur</button>
    </form>
</div>
<div class="modal" id="userEditModal">
    <i class="closeModal fas fa-times" onclick="closeModal('userEditModal')"></i>
    <h5>Kullanıcıyı Düzenle</h5>
    <form>
        <input type="hidden" name="id">
        <input type="text" name="username" placeholder="Kullanıcı adı">
        <input type="text" name="email" placeholder="Email">
        <input type="text" name="first_name" placeholder="Ad">
        <input type="text" name="last_name" placeholder="Soyad">
        <input type="text" name="full_address" placeholder="Adres">
        <select name="role">
        </select>
        <input type="password" name="password" placeholder="Şifre">
        <button type="submit">Düzenle</button>
    </form>
</div>
<div class="modal" id="userDeleteModal">
    <i class="closeModal fas fa-times" onclick="closeModal('userDeleteModal')"></i>
    <h5>Kullanıcıyı Sil</h5>
    <p>Bu kullanıcıyı silmek istediğinizden emin misiniz?</p>
    <form>
        <input type="hidden" name="id">
        <button type="submit">Sil</button>
    </form>
</div>

<div class="modal" id="productCreateModal">
    <i class="closeModal fas fa-times" onclick="closeModal('productCreateModal')"></i>
    <h5>Ürün Oluştur</h5>
    <form>
        <input type="text" name="name" placeholder="Ad">
        <input type="text" name="description" placeholder="Tanıtım">
        <input type="number" name="company_price" placeholder="Alış Fiyatı">
        <input type="number" name="sale_price" placeholder="Satış Fiyatı">
        <select name="category">
        </select>
        <button type="submit">Oluştur</button>
    </form>
</div>
<div class="modal" id="productEditModal">
    <i class="closeModal fas fa-times" onclick="closeModal('productEditModal')"></i>
    <h5>Ürün Güncelle</h5>
    <form>
        <input type="hidden" name="id">
        <input type="text" name="name" placeholder="Ad">
        <input type="text" name="description" placeholder="Tanıtım">
        <input type="number" name="company_price" placeholder="Alış Fiyatı">
        <input type="number" name="sale_price" placeholder="Satış Fiyatı">
        <select name="category">
        </select>
        <button type="submit">Düzenle</button>
    </form>
</div>
<div class="modal" id="productDeleteModal">
    <i class="closeModal fas fa-times" onclick="closeModal('productDeleteModal')"></i>
    <h5>Ürünü Sil</h5>
    <p>Bu ürünü silmek istediğinizden emin misiniz?</p>
    <form>
        <input type="hidden" name="id">
        <button type="submit">Sil</button>
    </form>
</div>


<script>

    function refreshUsers() {
        getUsers().then(x => {
            if(document.user.role_id != 1) {
                document.querySelector('.data-table[for="userTab"] .add-action').innerHTML = '';
            }
            let table = document.querySelector('.data-table[for="userTab"] tbody');
            table.innerHTML = '';
            //
            var userMap = {};

            for (let user of x) {
                userMap[user.id] = user;
                let tr = document.createElement('tr');
                tr.attributes['data-id'] = user.id;
                var actions = user.username == 'admin' || document.user.role_id != 1 ? '' : `
                    <i class="fas fa-edit" onclick="openUserUpdateModal(${user.id})"></i>
                    <i class="fas fa-trash" onclick="openUserDeleteModal(${user.id})"></i>
                `;
                tr.innerHTML = `
                <td class="actions">
                    <div>
                        ${actions}
                    </div>
                </td>
                <td>${user.username}</td>
                <td>${user.email}</td>
                <td>${user.first_name}</td>
                <td>${user.last_name}</td>
                <td>${user.full_address}</td>
                <td>${document.roles[user.role_id]}</td>
            `;
                table.appendChild(tr);
            }
            document.users = userMap;

        })
    }

    function refreshProducts() {
        getProducts().then(x => {
            if(document.user.role_id != 1) {
                document.querySelector('.data-table[for="productTab"] .add-action').innerHTML = '';
            }
            let table = document.querySelector('.data-table[for="productTab"] tbody');
            table.innerHTML = '';
            var productMap = {};
            for (let product of x) {
                productMap[product.id] = product;
                let tr = document.createElement('tr');
                tr.attributes['data-id'] = product.id;
                var actions = document.user.role_id != 1 ? '' : `
                    <i class="fas fa-edit" onclick="openProductUpdateModal(${product.id})"></i>
                    <i class="fas fa-trash" onclick="openProductDeleteModal(${product.id})"></i>
                `;
                tr.innerHTML = `
                <td class="actions">
                    <div>
                        ${actions}
                    </div>
                </td>
                <td>${product.name}</td>
                <td>${product.description}</td>
                <td>${product.company_price}</td>
                <td>${product.sale_price}</td>
                <td>${document.productCategories[product.category_id]}</td>
            `;
                table.appendChild(tr);
            }
            document.products = productMap;
        })
    }

    async function getPreliminaryData() {
        let roles = await getRoles();
        let productCategories = await getProductCategories();
        return {
            roles: roles,
            categories: productCategories
        }
    }

    getPreliminaryData().then(x => {
        var roleMap = {};
        for (let role of x.roles) {
            roleMap[role.id] = role.name;
        }
        document.roles = roleMap;

        let roleSelect = document.querySelectorAll('select[name="role"]');
        for (let s of roleSelect) {
            for (let role of x.roles) {
                let option = document.createElement('option');
                option.value = role.id;
                option.innerText = role.name;
                s.appendChild(option);
            }
        }


        console.log(x)

        var productCategoryMap = {};
        for (let productCategory of x.categories) {
            productCategoryMap[productCategory.id] = productCategory.name;
        }
        document.productCategories = productCategoryMap;


        let categorySelect = document.querySelectorAll('select[name="category"]');
        for (let s of categorySelect) {
            for (let productCategory of x.categories) {
                let option = document.createElement('option');
                option.value = productCategory.id;
                option.innerText = productCategory.name;
                s.appendChild(option);
            }
        }

        refreshUsers();
        refreshProducts();
    })


    function openUserUpdateModal(id) {
        let modal = document.querySelector("#userEditModal");
        var user = document.users[id];
        modal.querySelector('input[name="id"]').value = id;
        modal.querySelector('input[name="username"]').value = user.username;
        modal.querySelector('input[name="email"]').value = user.email;
        modal.querySelector('input[name="first_name"]').value = user.first_name;
        modal.querySelector('input[name="last_name"]').value = user.last_name;
        modal.querySelector('input[name="full_address"]').value = user.full_address;
        modal.querySelector('select[name="role"]').value = user.role_id;

        openModal('userEditModal');
    }

    function openProductUpdateModal(id) {
        let modal = document.querySelector("#productEditModal");
        var product = document.products[id];
        modal.querySelector('input[name="id"]').value = id;
        modal.querySelector('input[name="name"]').value = product.name;
        modal.querySelector('input[name="description"]').value = product.description;
        modal.querySelector('input[name="company_price"]').value = product.company_price;
        modal.querySelector('input[name="sale_price"]').value = product.sale_price;
        modal.querySelector('select[name="category"]').value = product.category_id;


        openModal('productEditModal');
    }

    function openUserDeleteModal(id) {
        let modal = document.querySelector("#userDeleteModal");
        modal.querySelector('input[name="id"]').value = id;
        openModal('userDeleteModal');
    }

    function openProductDeleteModal(id) {
        let modal = document.querySelector("#productDeleteModal");
        modal.querySelector('input[name="id"]').value = id;
        openModal('productDeleteModal');
    }

    document.querySelector("#userCreateModal").querySelector('form').addEventListener('submit', e => {
        e.preventDefault();
        let form = e.target;
        let data = {
            username: form.querySelector('input[name="username"]').value,
            email: form.querySelector('input[name="email"]').value,
            first_name: form.querySelector('input[name="first_name"]').value,
            last_name: form.querySelector('input[name="last_name"]').value,
            full_address: form.querySelector('input[name="full_address"]').value,
            role_id: form.querySelector('select[name="role"]').value,
            password: form.querySelector('input[name="password"]').value
        }
        createUser(data).then(x => {
            refreshUsers()
            closeModal('userCreateModal');
        })
    });

    document.querySelector("#productCreateModal").querySelector('form').addEventListener('submit', e => {
        e.preventDefault();
        let form = e.target;
        let data = {
            name: form.querySelector('input[name="name"]').value,
            description: form.querySelector('input[name="description"]').value,
            company_price: form.querySelector('input[name="company_price"]').value,
            sale_price: form.querySelector('input[name="sale_price"]').value,
            category_id: form.querySelector('select[name="category"]').value
        }
        createProduct(data).then(x => {
            refreshProducts()
            closeModal('productCreateModal');
        })
    });

    document.querySelector("#userEditModal").querySelector('form').addEventListener('submit', e => {
        e.preventDefault();
        let form = e.target;
        let data = {
            id: form.querySelector('input[name="id"]').value,
            username: form.querySelector('input[name="username"]').value,
            email: form.querySelector('input[name="email"]').value,
            first_name: form.querySelector('input[name="first_name"]').value,
            last_name: form.querySelector('input[name="last_name"]').value,
            full_address: form.querySelector('input[name="full_address"]').value,
            role_id: form.querySelector('select[name="role"]').value,
            password: form.querySelector('input[name="password"]').value
        }
        updateUser(data).then(x => {
            refreshUsers()
            closeModal('userEditModal');
        })
    });

    document.querySelector("#productEditModal").querySelector('form').addEventListener('submit', e => {
        e.preventDefault();
        let form = e.target;
        let data = {
            id: form.querySelector('input[name="id"]').value,
            name: form.querySelector('input[name="name"]').value,
            description: form.querySelector('input[name="description"]').value,
            company_price: form.querySelector('input[name="company_price"]').value,
            sale_price: form.querySelector('input[name="sale_price"]').value,
            category_id: form.querySelector('select[name="category"]').value
        }
        updateProduct(data).then(x => {
            refreshProducts()
            closeModal('productEditModal');
        })
    });

    document.querySelector("#userDeleteModal").querySelector('form').addEventListener('submit', e => {
        e.preventDefault();
        let form = e.target;
        let data = {
            id: form.querySelector('input[name="id"]').value
        }
        deleteUser(data).then(x => {
            refreshUsers()
            closeModal('userDeleteModal');
        })
    });

    document.querySelector("#productDeleteModal").querySelector('form').addEventListener('submit', e => {
        e.preventDefault();
        let form = e.target;
        let data = {
            id: form.querySelector('input[name="id"]').value
        }
        deleteProduct(data).then(x => {
            refreshProducts()
            closeModal('productDeleteModal');
        })
    });
</script>
