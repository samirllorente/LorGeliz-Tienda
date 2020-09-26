
const product = new Vue({
    el: '#product_cart',
    data: {
      nombre: '',
      slug: '',
      cantidad: '',
      producto: '',
      carrito: '',
      cantidad: '',
      talla: 0,
      arrayTallas: [],
      arrayCarrito: [],
    }, 
    
    methods: {
      setVisitas(){

        let url = '/lorgeliz_tienda/public/admin/productos/visitas/update/'+this.producto;

        axios.put(url).then(response => {
          
        }); 

      },

      getTallas(){

        let url = '/lorgeliz_tienda/public/admin/tallas/productos/'+this.producto;

        axios.get(url).then(response => {
          this.arrayTallas = response.data.tallas;
        }); 

      }, 

      getCarrito(){
        let url = '/lorgeliz_tienda/public/cart/buscarCarrito';

        axios.get(url).then(response => {
          this.arrayCarrito = response.data.carrito;

          if (this.arrayCarrito[0] != null){
            this.carrito = this.arrayCarrito[0].id;

            let url = '/lorgeliz_tienda/public/cart/updateCart';

            axios.post(url,{
              'producto': this.producto,
              'talla': this.talla,
              'cantidad': this.cantidad,
              'carrito': this.carrito

            }).then(function (response) {

              swal(
                'Producto agregado al carrito!',
                'Haz agregado este producto a tu carrito',
                'success'
              )   

            }).catch(function (error) {
              console.log(error);
            }); 
        
          } else{

            let url = '/lorgeliz_tienda/public/cart/add_product';

            axios.post(url,{
              'producto': this.producto,
              'talla': this.talla,
              'cantidad': this.cantidad

            }).then(function (response) {
              
              swal(
                'Producto agregado al carrito!',
                'Haz agregado este producto a tu carrito',
                'success'
              )
                      
            }).catch(function (error) {
              console.log(error);
            });
          }

        }); 

      }
    },
    mounted(){
      this.producto = data.datos.producto;
      this.setVisitas();
      this.getTallas();
    }

});