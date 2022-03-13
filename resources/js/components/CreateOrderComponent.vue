<template>

    <div>
    
        <div class="form-group">
            
            <label for="newArticleCode">Article Code:</label>
            <input type="text" class="form-control" id="newArticleCode" aria-describedby="newArticleCodeHelp" placeholder="Enter the Article Code" v-model="ArticleCode">
            
            <label for="newArticleName">Article Name:</label>
            <input type="text" class="form-control" id="newArticleName" aria-describedby="newArticleNameHelp" placeholder="Enter the Article Name" v-model="ArticleName">

            <label for="newUnitPrice">Unit Price:</label>
            <input type="text" class="form-control" id="newUnitPrice" aria-describedby="newUnitPriceHelp" placeholder="Enter the Unit Price" v-model="UnitPrice">
            
            <label for="newQuantity">Quantity:</label>
            <input type="text" class="form-control" id="newQuantity" aria-describedby="newQuantityHelp" placeholder="Enter the Quantity" v-model="Quantity">
            
        </div>
        <div class="col-md-12">
            <div class="row">
                <button v-if="transactionStatus!='success'" type="button" class="btn btn-primary mt-0" @click="save()">Save</button>
                
                <div class="card mt-2 text-success" v-if="transactionStatus==='success'">
                    OrderId: {{ ApiResponse.OrderId }}, <br>
                    OrderCode: {{ ApiResponse.OrderCode }}, <br> 
                    OrderDate: {{ ApiResponse.OrderDate }}, <br> 
                    TotalAmountWithDiscount: {{ ApiResponse.TotalAmountWithDiscount }}, <br> 
                    TotalAmountWithoutDiscount: {{ ApiResponse.TotalAmountWithoutDiscount }}
                </div>

            </div>

            <div class="card ml-2 mt-2 text-danger" v-if="transactionStatus==='error'">
                Status: {{ transactionStatus }}, <br>
                Message: {{ transactionDetails.message }}, <br> 
                Details: {{ transactionDetails.transaction_details }}, <br> 
            </div>
        </div>   

    </div>

            

</template>

<script>

    export default {

        data() {
            return {
                urlCreate: 'http://localhost:80/api/v1/order',

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
        methods: {
            resetState() {
                this.transactionStatus = '';
                this.transactionDetails = {};
                this.ArticleCode = '';
                this.ArticleName = '';
                this.UnitPrice = '';
                this.Quantity = '';
            },
            save() {
               
                let formData = new FormData();
                formData.append('article_name', this.ArticleName);
                formData.append('article_code', this.ArticleCode);
                formData.append('unit_price', this.UnitPrice);
                formData.append('quantity', this.Quantity);

                let config = {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }

                axios.post(this.urlCreate, formData, config)
                    .then(response => {
                        this.transactionStatus = 'success';
                        this.ApiResponse.OrderId = response.data.OrderId;
                        this.ApiResponse.OrderCode = response.data.OrderCode;
                        this.ApiResponse.OrderDate = response.data.OrderDate;
                        this.ApiResponse.TotalAmountWithDiscount = response.data.TotalAmountWithDiscount;
                        this.ApiResponse.TotalAmountWithoutDiscount = response.data.TotalAmountWithoutDiscount;
                    })
                    .catch(errors => {
                        this.transactionStatus = 'error';
                        this.transactionDetails = {
                            message: errors.response.data.message,
                            transaction_details: errors.response.data.errors
                        };
                    });
                setTimeout(() => {
                    this.resetState();
                }, 10000);
                    
            }
            
        },
        beforeMounted() {
            //this.checkResponse();
        }

    }

</script>