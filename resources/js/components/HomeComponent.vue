<template>
    <div class="container">

        
        <div class="col-md-6">
            <div v-if="!creating && !listing">
                <div class="card">
                    <div class="card-header text-center">
                        Order App
                    </div>
                    <div class="card-body text-center" dusk="show-buttons">
                        <button class="btn btn-primary mb-2" @click="listOrders()">Show Orders</button>
                        <button class="btn btn-secondary mb-2" @click="createOrder()">Create an Order</button>
                    </div>
                </div>
            </div>

            <div v-if="!creating && listing">
                <orders-component></orders-component>
            </div>

            <div v-if="creating && !listing">
                <create-order-component></create-order-component>
            </div>

            <button class="btn btn-secondary mt-2" v-if="creating || listing" @click="restart()">Back</button>
            
        </div>

    </div>
</template>

<script>
import CreateOrderComponent from './CreateOrderComponent.vue';
import OrdersComponent from './OrdersComponent.vue';
    export default {
  components: { CreateOrderComponent, OrdersComponent },
        
        data() {
            return {
                creating: false,
                listing: false
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            createOrder() {
                this.creating = true;
            },
            listOrders() {
                this.listing = true;
            },
            restart() {
                this.creating = false;
                this.listing = false;
            }
        }
    }
</script>
