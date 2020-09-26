
window.Vue = require('vue');


Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('products-category', require('./components/ProductsCategory.vue').default);

if (document.getElementById('app')) {
    const app = new Vue({
        el: '#app',
    });
    
}

if (document.getElementById('product_cart')) {
    require('./tienda/product');
}

if (document.getElementById('print_venta')) {
    require('./admin/print_venta');
}

if (document.getElementById('productos')) {
    require('./admin/product');
}

if (document.getElementById('venta_cliente')) {
    require('./tienda/venta_cliente');
}

if (document.getElementById('carrito')) {
    require('./tienda/cart');
}

if (document.getElementById('checkout')) {
    require('./tienda/checkout');
}

if (document.getElementById('pedidos')) {
    require('./tienda/orders');
}

if (document.getElementById('categoria')) {
    require('./tienda/category');
}

if (document.getElementById('informeventa')) {
    require('./admin/informe-ventas');
}

if (document.getElementById('informeproducto')) {
    require('./admin/informe-productos');
}

if (document.getElementById('informecliente')) {
    require('./admin/informe-clientes');
}

if (document.getElementById('infventashow')) {
    require('./admin/print-ventas-show');
}