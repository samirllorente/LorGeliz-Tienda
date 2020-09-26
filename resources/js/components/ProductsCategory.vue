<template>
    <!-- Product -->
    
    <!--<div class="col-xl-4 col-md-6 grid-item hot" v-for="(item, index) in arrayProductos" :key="item.cop">
        <div class="product">
            <div class="product_image"><img src="" alt=""></div>
            <div class="product_content">
                <div class="product_info d-flex flex-row align-items-start justify-content-start">
                    <div>
                        <div>
                            <div class="product_name"><a href="product.html"></a></div>
                            
                        </div>
                    </div>
                    <div class="ml-auto text-right">
                        <div class="product_category">In <a href="category.html">Category</a></div>
                        <div class="product_price text-right">$3<span>.99</span></div>
                    </div>
                </div>
                <div class="product_buttons">
                    <div class="text-right d-flex flex-row align-items-start justify-content-start">										
                        <div class="product_button product_cart text-center d-flex flex-column align-items-center justify-content-center">
                            <div><div><img src="" class="svg" alt=""><div>+</div></div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>!-->

</template>

<script>
    export default {
        data (){
            return {
                categoria: '',
                arrayProductos: []
            }
        },
        methods : {
            getproductos(){
                let url = '/lorgeliz_tienda/public/categorias/productos';

                axios.get(url).then(response => {
                   // var respuesta= response.data;
                    //me.arrayVenta = respuesta.ventas.data;
                    this.arrayProductos = response.data;
                    console.log(this.arrayProductos);
                }); 

            },
        },
        mounted() {
           this.getproductos();
        }
    }
</script>
