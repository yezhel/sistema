<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Escritorio</a></li>
        </ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Artículo
                    <button type="button" @click="abrirModal('articulo','registrar')" class="btn btn-secondary">
                        <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                    <option value="nombre">Nombre</option>
                                    <option value="descripcion">Descripción</option>
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listarArticulo(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listarArticulo(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Categoría</th>
                                <th>Precio Venta</th>
                                <th>Stock</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- :key="", indica que el campo es una llave primaria -->
                            <tr v-for="articulo in arrayArticulo" :key="articulo.id">
                                <td>
                                    <button type="button" @click="abrirModal('articulo','actualizar',articulo)" class="btn btn-warning btn-sm">
                                      <i class="icon-pencil"></i>
                                    </button> &nbsp;
                                    <template v-if="articulo.condicion">
                                        <button type="button" class="btn btn-danger btn-sm" @click="desactivarArticulo(articulo.id)">
                                            <i class="icon-trash"></i>
                                        </button>
                                    </template>
                                    <template v-else>
                                        <button type="button" class="btn btn-info btn-sm" @click="activarArticulo(articulo.id)">
                                            <i class="icon-check"></i>
                                        </button>
                                    </template>
                                </td>
                                <td v-text="articulo.codigo"></td>
                                <td v-text="articulo.nombre"></td>
                                <td v-text="articulo.nombre_categoria"></td>
                                <td v-text="articulo.precio_venta"></td>
                                <td v-text="articulo.stock"></td>
                                <td v-text="articulo.descripcion"></td>
                                <td>
                                    <div v-if="articulo.condicion">
                                        <span class="badge badge-success">Activo</span>
                                    </div>
                                    <div v-else>
                                        <span class="badge badge-danger">Desactivado</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination">
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <!-- @click.prevent, llama al evento click.prevente -->
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                            </li>
                            <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page==isActived ? 'active' : '']">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                            </li>
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>
        <!--Inicio del modal agregar/actualizar-->
        <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                        <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Categoria</label>
                                <div class="col-md-9">
                                    <select class="form-control" v-model="idcategoria">
                                        <option value="0" disabled>Seleccione</option>
                                        <option v-for="categoria in arrayCategoria" :key="categoria.id" :value="categoria.id" v-text="categoria.nombre"></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Código</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="codigo" class="form-control" placeholder="Código de barras">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="nombre" class="form-control" placeholder="Nombre del artículo">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Precio de venta</label>
                                <div class="col-md-9">
                                    <input type="number" v-model="precio_venta" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Stock</label>
                                <div class="col-md-9">
                                    <input type="number" v-model="stock" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                                <div class="col-md-9">
                                    <input type="email" v-model="descripcion" class="form-control" placeholder="Ingrese descripción">
                                </div>
                            </div>
                            <div v-show="errorArticulo" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjArticulo" :key="error" v-text="error">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarArticulo()">Guardar</button>
                        <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarArticulo()">Actualizar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--Fin del modal-->
    </main>
</template>

<script>
    export default {
        data(){
            return {
                articulo_id : 0,
                idcategoria : 0,
                nombre_categoria : '',
                codigo : '',
                nombre : '',
                precio_venta : 0,
                stock : 0,
                descripcion : '',
                arrayArticulo : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorArticulo : 0,
                errorMostrarMsjArticulo : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'nombre',//campo de busqueda
                buscar : '',//texto de busqueda
                arrayCategoria : []
            }
        },
        computed : {
            isActived : function(){
                return this.pagination.current_page;
            },
            pagesNumber : function(){
                if(!this.pagination.to){
                    return [];
                }
                var from = this.pagination.current_page - this.offset;
                if(from < 1)
                {
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while(from <= to){
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            }
        },
        methods : {
            listarArticulo(page, buscar, criterio){
                let me = this;
                var url = '/articulo?page=' + page + '&buscar=' + buscar + '&criterio=' +criterio;
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                    // handle success
                    var respuesta = response.data;
                    me.arrayArticulo = respuesta.articulos.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            selectCategoria(){
                let me = this;
                var url = '/categoria/selectCategoria';
                // Make a request for a user with a given ID
                axios.get(url).then(function (response) {
                    // handle success
                    var respuesta = response.data;
                    me.arrayCategoria = respuesta.categorias;//en consola muestra data: categorias
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            cambiarPagina(page, buscar, criterio){
                let me = this;

                //Actualiza la pagina actual
                me.pagination.current_page = page;

                //Envia la petición para visualizar la data de esta página
                me.listarArticulo(page,buscar,criterio);

            },
            registrarArticulo(){
                if(this.validarArticulo()){
                    return;
                }

                let me = this;

                //envia datos por post a la URL dada, con los parametros dados
                axios.post('/articulo/registrar',{
                    'idcategoria' : this.idcategoria,
                    'codigo' : this.codigo,
                    'nombre' : this.nombre,
                    'stock' : this.stock,
                    'precio_venta' : this.precio_venta,
                    'descripcion' : this.descripcion

                }).then(function (response) {
                    //Si sale bien
                    me.cerrarModal();
                    me.listarArticulo(1,'','nombre');

                }).catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            actualizarArticulo(){
                if(this.validarArticulo()){
                    return;
                }
                let me = this;

                //envia datos por post a la URL dada, con los parametros dados
                axios.put('/articulo/actualizar',{
                    'idcategoria' : this.idcategoria,
                    'codigo' : this.codigo,
                    'nombre' : this.nombre,
                    'stock' : this.stock,
                    'precio_venta' : this.precio_venta,
                    'descripcion' : this.descripcion,
                    'id' : this.articulo_id

                }).then(function (response) {
                    //Si sale bien
                    me.cerrarModal();
                    me.listarArticulo(1,'','nombre');

                }).catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            desactivarArticulo(id){
                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                    title: 'Estas seguro de desactivar este artículo?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value)
                    {
                        let me = this;
                        //envia datos por post a la URL dada, con los parametros dados
                        axios.put('/articulo/desactivar',{
                            'id' : id
                        }).then(function (response) {
                            //Si sale bien
                            me.listarArticulo(1,'','nombre');
                            swalWithBootstrapButtons(
                                'Desactivado!',
                                'El registro ha sido desactivado con éxito.',
                                'success'
                            )
                        }).catch(function (error) {
                            // handle error
                            console.log(error);
                        });
                    } 
                    else if (// Read more about handling dismissals
                                result.dismiss === swal.DismissReason.cancel
                            )
                        {
                        
                        }
                })
            },
            activarArticulo(id){
                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                    title: 'Estas seguro de activar este artículo?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value)
                    {
                        let me = this;
                        //envia datos por post a la URL dada, con los parametros dados
                        axios.put('/articulo/activar',{
                            'id' : id
                        }).then(function (response) {
                            //Si sale bien
                            me.listarArticulo(1,'','nombre');
                            swalWithBootstrapButtons(
                                'Activado!',
                                'El registro ha sido activado con éxito.',
                                'success'
                            )
                        }).catch(function (error) {
                            // handle error
                            console.log(error);
                        });
                    } 
                    else if (// Read more about handling dismissals
                                result.dismiss === swal.DismissReason.cancel
                            )
                        {
                        
                        }
                })
            },
            validarArticulo(){
                //Inicializa las variables
                this.errorArticulo = 0;
                this.errorMostrarMsjArticulo = [];

                if(this.idcategoria == 0 )
                    this.errorMostrarMsjArticulo.push("Seleccione una categoria");

                if(!this.nombre) 
                    this.errorMostrarMsjArticulo.push("El nombre del artículo no puede estar vacio.");

                if(this.stock == 0 )
                    this.errorMostrarMsjArticulo.push("El stock del artículo debe ser un número y no puede estar vacio.");

                if(this.precio_venta == 0 )
                    this.errorMostrarMsjArticulo.push("El precio de venta del artículo debe ser un número y no puede estar vacion");



                if(this.errorMostrarMsjArticulo.length)
                    this.errorArticulo = 1;

                return this.errorArticulo;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal = '';
                this.idcategoria = 0;
                this.nombre_categoria = '';
                this.codigo = '';
                this.nombre = '';
                this.precio_venta = 0;
                this.stock = 0;
                this.descripcion = '';
                this.errorArticulo = 0;
            },
            abrirModal(modelo, accion, data = []){
                switch (modelo) {
                    case "articulo":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                //Cambiamos el valor de la variable modal
                                this.modal = 1;
                                this.tituloModal = 'Registrar Artículo';
                                this.idcategoria = 0;
                                 
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                //Muestra una ventana modal
                                this.modal = 1;
                                this.tituloModal = 'Actualizar Artículo';
                                this.tipoAccion = 2;
                                this.articulo_id = data['id'];
                                this.idcategoria = data['idcategoria'];
                                this.codigo = data['codigo'];
                                this.nombre = data['nombre'];
                                this.stock = data['stock'];
                                this.precio_venta = data['precio_venta'];
                                this.descripcion = data['descripcion'];
                                break;
                            }
                        }
                    }
                }
                this.selectCategoria();
            }
        },
        mounted() {
            this.listarArticulo(1,this.buscar,this.criterio);
        }
    }
</script>
<style>
    .model-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position : absolute !important;
        background : #3c29297a !important;
    }
    .div-error{
        display : flex;
        justify-content: center;
    }
    .text-error{
        color : red !important;
        font-weight: bold;
    }
</style>