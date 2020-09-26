

const product = new Vue({
    el: '#carrito',
    data: {
        precio: 0,
        cantidad: 0,
        totalproducto: 0,
        arrayproducto: [],
        clicks: 0,
        minus: 0,
        total: 0,
        codigo: 0
    }, 

    methods: {
        
        aumentar(cantidad, precio, codigo){
            if (this.clicks_add == 0) {
                this.codigo = codigo;
            }

            if (this.codigo != codigo) {
                this.clicks_add = 0;
                this.codigo = codigo;
            }
            
            this.clicks_add = this.clicks_add + 1;
            this.cantidad = cantidad + this.clicks_add;
            this.precio = precio;
            this.totalproducto = this.cantidad * this.precio;
            
            this.arrayproducto[codigo] = this.totalproducto;
        },

        disminuir(cantidad, precio, codigo){
            this.minus = this.minus + 1;
            this.cantidad = cantidad - this.minus;
            this.precio = precio;
            this.totalproducto = this.cantidad * this.precio;
            
            this.arrayproducto[codigo] = this.totalproducto;
        },

        comprobar(codigo){
           
            if (this.clicks_add == 0) {
                if (this.minus == 0) {
                    for (let i = 0; i < this.arrayproducto.length; i++) {
                        this.arrayproducto[i] = 0;
                    }
                    this.arrayproducto[codigo] = 0;
                }  
            }
            
            return this.arrayproducto[codigo];
            
        },

        totalcarrito(cantidad){
            this.total = cantidad;
        }
    },

    mounted(){
       
    }

});