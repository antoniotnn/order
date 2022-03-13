<template>
    <div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">OrderId</th>
                    <th scope="col">OrderCode</th>
                    <th scope="col">OrderDate</th>
                    <th scope="col">TotalAmountWithDiscount</th>
                    <th scope="col">TotalAmountWithoutDiscount</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="order, o in orders" :key="o">
                    <td v-for="value in order" :key="value">
                        <span>{{value}}</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>


export default {
    data() {
        return {
            urlListOrders: 'http://localhost:80/api/v1/order',

                orders: { data: [] },

                ArticleCode: '',
                ArticleName: '',
                UnitPrice: '',
                Quantity: '',
                ApiResponse: {
                    OrderId: '',
                    OrderCode: '',
                    OrderDate: '',
                    TotalAmountWithDiscount: '',
                    TotalAmountWithoutDiscount: '',
                },
                transactionStatus: '',
                transactionDetails: {}
        }
    },
    methods : {
        reloadOrders() {
            let url = this.urlListOrders;

            axios.get(url)
                .then(response => {
                    this.orders = response.data;
                })
                .catch(errors => {
                    console.log(errors);
                });
        }
    },
    mounted() {
        this.reloadOrders();
    }
}
</script>
