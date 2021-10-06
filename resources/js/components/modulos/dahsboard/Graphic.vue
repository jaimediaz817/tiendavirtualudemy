<template>
    <div class="row">
        <template v-if="listRolPermisosByUsuario.includes('productos.mas.vendidos')">
            <div class="col-md-6">
                <canvas id="myChart" width="400" height="200"></canvas>
            </div>
        </template>

        <template v-if="listRolPermisosByUsuario.includes('ventas.por.dia')">
            <div class="col-md-6">
                <canvas id="myChart2" width="400" height="200"></canvas>
            </div>
        </template>
    </div>
</template>

<script>
var Chart = require('chart.js');

export default {
    data() {
        return {
            listProductosMasVendidos: {
                all:      [],
                name:     [],
                cantidad: [],
                colores:  []
            },

            listVentasPorDia: {
                all:      [],
                name:     [],
                cantidad: [],
                dia:      [],
                total:    [],
                colores:  []
            },
            listRolPermisosByUsuario: JSON.parse(sessionStorage.getItem('listRolPermisosByUsuario')),
        }
    },
    mounted() {
        this.getProductosMasVendidos();
        this.getVentasPorDia();
    },
    methods: {
        // PRODUCTOS MÁS VENDIDOS
        getProductosMasVendidos()
        {
            this.fullscreenLoading = true;
            var url = '/dashboard/getProductosMasVendidos'

            axios.get(url).then( response => {
                this.listProductosMasVendidos.all = response.data;
                this.getProductosMasVendidosFilter();
            }).catch(error => {
                if (error.response && error.response.status == 401) {
                    this.$router.push({name: 'login'})
                    location.reload();
                    sessionStorage.clear();
                    this.fullscreenLoading = false;
                }
            });
        },
        getProductosMasVendidosFilter()
        {
            let me = this;
            this.listProductosMasVendidos.all.map( function(x, y) {
                me.listProductosMasVendidos.name.push(x.name);
                me.listProductosMasVendidos.cantidad.push(x.cantidad);

                let param1 = Math.floor(Math.random() * 256); // 0 - 255
                let param2 = Math.floor(Math.random() * 256); // 0 - 255
                let param3 = Math.floor(Math.random() * 256); // 0 - 255

                let color  = 'rgba('+param1+', '+param2+', '+param3+', 0.2)';

                me.listProductosMasVendidos.colores.push(color);
            });

            this.getGraficoBarProductosMasVendidos();
        },
        getGraficoBarProductosMasVendidos()
        {
            var ctx = document.getElementById('myChart');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: this.listProductosMasVendidos.name,
                    datasets: [{
                        label: 'Gráfico: Productos más vendidos',
                        data: this.listProductosMasVendidos.cantidad,
                        backgroundColor: this.listProductosMasVendidos.colores,
                        borderColor:     this.listProductosMasVendidos.colores,
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        },




        // VENTAS POR DÍA DEL MES ACTUAL
        getVentasPorDia()
        {
            this.fullscreenLoading = true;
            var url = '/dashboard/getVentasPorDia'

            axios.get(url).then( response => {
                this.listVentasPorDia.all = response.data;
                console.log("ventas por dia: ", this.listVentasPorDia.all)
                this.getVentasPorDiaFilter();
            }).catch(error => {
                if (error.response && error.response.status == 401) {
                    this.$router.push({name: 'login'})
                    location.reload();
                    sessionStorage.clear();
                    this.fullscreenLoading = false;
                }
            });
        },
        getVentasPorDiaFilter()
        {
            let me = this;
            this.listVentasPorDia.all.map( function(x, y) {
                me.listVentasPorDia.name.push(x.dia);
                me.listVentasPorDia.cantidad.push(x.total);

                let param1 = Math.floor(Math.random() * 256); // 0 - 255
                let param2 = Math.floor(Math.random() * 256); // 0 - 255
                let param3 = Math.floor(Math.random() * 256); // 0 - 255

                let color  = 'rgba('+param1+', '+param2+', '+param3+', 0.2)';

                me.listVentasPorDia.colores.push(color);
            });

            this.getGraficoBarVentasPorDia();
        },
        getGraficoBarVentasPorDia()
        {
            var ctx = document.getElementById('myChart2');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: this.listVentasPorDia.name,
                    datasets: [{
                        label: 'Gráfico: Ventas por día del mes actual',
                        data: this.listVentasPorDia.cantidad,
                        backgroundColor: this.listVentasPorDia.colores,
                        borderColor:     this.listVentasPorDia.colores
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        },
    }
}
</script>

<style>

</style>
