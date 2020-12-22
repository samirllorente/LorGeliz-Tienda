<template>
    <div>

        <div v-for="producto in arrayProductos" :key="producto.cop">
        </div>

    </div>
    
</template>

<script>
    export default {
        data (){
            return {
                categorias: '',
                array: []
            }
        },
        methods : {
            getproductos(){
                
            },
        },
        mounted() {
          
        }
    }
</script>
