
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
      stock: 0,
      select: true
    }, 
    
    methods: {
      setVisitas(){

        let url = '/lorgeliz_tienda/public/productos/visitas/update/'+this.producto;

        axios.put(url).then(response => {
          
        }); 

      },

      change(){
        this.select =  !this.select;
      },

      setStock(){
        if (this.talla != 0 ) {
          for (let i = 0; i < this.arrayTallas.length; i++) {
            if (this.arrayTallas[i].id == this.talla) {
              this.stock = this.arrayTallas[i].stock;
            }
          }
        }
        else{
          this.stock = 0;
        }
      },

      getTallas(){

        let url = '/lorgeliz_tienda/public/tallas/productos/'+this.producto;

        axios.get(url).then(response => {
          this.arrayTallas = response.data.tallas;
        }); 

      }, 

      getCarrito(){
        let url = '/lorgeliz_tienda/public/cart/buscarCarrito';

        if (this.cantidad != '' && this.talla != '') {
          axios.get(url).then(response => {
            this.arrayCarrito = response.data.carrito;
  
            if (this.arrayCarrito[0] != null){
              this.carrito = this.arrayCarrito[0].id;
  
              let url = '/lorgeliz_tienda/public/cart/updateCart';
  
              for (let i = 0; i < this.arrayTallas.length; i++) {
                if (this.arrayTallas[i].id == this.talla) {
                  if (this.cantidad <= this.arrayTallas[i].stock ) {
                    axios.post(url,{
                      'producto': this.producto,
                      'talla': this.talla,
                      'cantidad': this.cantidad,
                      'carrito': this.carrito
        
                    }).then(function (response) {
  
                      if (response.data.data == 'error') {
  
                        var unidades = parseInt(response.data.carrito);
                        var actual = parseInt(response.data.stock);
                        var restantes = actual - unidades;
  
                        if (restantes == 0) {
                          swal(
                          'Producto agotado!',
                          'No puedes agregar más unidades de este producto a tu carrito!',
                          'error'
                          )
                        }
                        else{
                          swal(
                            'Producto con stock limitado!',
                            'Puedes agregar a tu carrito sólo ' + restantes + ' unidad(es) más de este producto',
                            'error'
                          )
                        }
                      }
                      else{
  
                        swal(
                        'Producto agregado al carrito!',
                        'Haz agregado este producto a tu carrito',
                        'success'
                       )   
  
                      }
        
                    }).catch(function (error) {
                      console.log(error);
                    }); 
                  } else{
                    swal(
                      'No se puede agregar el producto al carrito!',
                      'La cantidad debe ser máximo ' + this.arrayTallas[i].stock,
                      'error'
                    )   
                  }
                }
                
              }
          
            } else{
  
              let url = '/lorgeliz_tienda/public/cart/store';
  
              for (let i = 0; i < this.arrayTallas.length; i++) {
               if (this.arrayTallas[i].id == this.talla) {
                 if (this.cantidad <= this.arrayTallas[i].stock) {
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
                  else{
                    swal(
                      'No se puede agregar el producto al carrito!',
                      'La cantidad debe ser máximo ' + this.arrayTallas[i].stock,
                      'error'
                    )   
                  }
               }
                
              }
  
            }
  
          }); 
          
        }

      },

    },
    mounted(){
      this.producto = data.datos.producto;
      this.setVisitas();
      this.getTallas();
    }

});