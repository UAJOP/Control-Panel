

<div class="card yellow-tint statistic-cars">
    <h1>Yeni Siparişler</h1>
    <div id="newOrders" class="content">
    </div>
</div>

<div class="card blue-tint statistic-cars">
    <h1>Müşteri Sayısı</h1>
    <div id="customerCount" class="content">
    </div>
</div>

<div class="card green-tint statistic-cars">
    <h1>Gelir</h1>
    <div id="revenue" class="content">
    </div>
</div>

<div class="card red-tint statistic-cars">
    <h1>Satılan Ürünler</h1>
    <div id="productsSold" class="content">
    </div>
</div>


<div class="card purple-tint" style="grid-column: span 5; grid-row: span 2;">
    <h1>Satışlar</h1>
    <div class="content">
        <canvas id="salesChart"></canvas>
    </div>
</div>

<div class="card orange-tint" style="grid-column: span 3; grid-row: span 2;">
    <h1>En Çok Satılan Ürünler</h1>
    <div class="content">
    </div>
</div>


<script>


    getDashboardInfo()
        .then(x => {
            document.querySelector("#newOrders").innerText = x.numOrders;
            document.querySelector("#customerCount").innerText = x.numCustomers;
            document.querySelector("#revenue").innerText = x.revenue ? x.revenue : 0;
            document.querySelector("#productsSold").innerText = x.productsSold ? x.productsSold : 0;

            new Chart(document.querySelector("#salesChart"), {
                type: 'line',
                data: {
                    labels: x.sales.map(sale => sale.date),
                    datasets: [{
                        label: 'Sales',
                        data: x.sales.map(sale => sale.numOrders),
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        })
</script>
