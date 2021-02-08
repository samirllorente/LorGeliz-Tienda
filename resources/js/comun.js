
window.Vue = require('vue');


Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('category', require('./components/Category.vue').default);


if (document.getElementById('app')) {
    const app = new Vue({
        el: '#app',
    });
}

if (document.getElementById('product_cart')) {
    require('./tienda/product');
}
if (document.getElementById('inicio')) {
    require('./tienda/index');
}

if (document.getElementById('menu')) {
    require('./tienda/getCategory');
}

if (document.getElementById('clientNotification')) {
    require('./tienda/notifications');
}

if (document.getElementById('notification')) {
    require('./admin/notifications');
}

if (document.getElementById('imprimir_pedidos')) {
    require('./admin/imprimir_pedidos');
}

if (document.getElementById('productos')) {
    require('./admin/product');
}

if (document.getElementById('venta_cliente')) {
    require('./tienda/facturacliente');
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

if (document.getElementById('listventas')) {
    require('./admin/listadoventas');
}

if (document.getElementById('listdevolucion')) {
    require('./admin/listadodevoluciones');
}

if (document.getElementById('listclientes')) {
    require('./admin/listadoclientes');
}

if (document.getElementById('inventarios')) {
    require('./admin/inventarios');
}

if (document.getElementById('payments')) {
    require('./admin/listadopagos');
}

if (document.getElementById('user_cart')) {
    require('./tienda/userCart');
}

if (document.getElementById('factura_venta')) {
    require('./admin/factura_venta');
}


