<template>
    <div class="container">
        <div class="row pt-5">
            <div class="col-lg-12 d-flex justify-content-center">
                <div class="alert alert-primary" role="alert">
                    CRUD Laravel - Vue 2 using Bootstrap 4!
                </div>
            </div>
        </div>
        <div class="row pt-5">

            <div class="col-lg-12 d-flex justify-content-end pb-2">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#create-item">
                    Add item <i class="fa fa-plus" aria-hidden="true"></i>
                </button>
            </div>

            <div class="col-lg-12 d-flex justify-content-center">
                <div v-if="!items.length" class="alert alert-danger" role="alert">
                    Not items <i class="fa fa-frown-o" aria-hidden="true"></i>
                </div>
            </div>

            <div v-for="item in items" class="col-lg-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h4 class="card-title">{{ item.title }}</h4>
                        <p class="card-text">{{ item.description }}</p>
                        <button type="button" class="btn btn-primary" @click.prevent="editItem( item )" ><i class="fa fa-pencil" aria-hidden="true"></i></button>
                        <button type="button" class="btn btn-danger" @click.prevent="deleteItem( item )"><i class="fa fa-trash" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>

            <!-- Create Item Modal -->
            <div class="modal fade" id="create-item" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create item</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="post" enctype="multipart/form-data" @submit.prevent="createItem">
                            <div class="modal-body">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control" id="title" placeholder="Enter title" v-model="newItem.title">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control" id="description" rows="3" placeholder="Enter description" v-model="newItem.description"></textarea>
                                        </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Eit item Modal -->
            <div class="modal fade" id="edit-item" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit item</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="post" enctype="multipart/form-data" @submit.prevent="updateItem( fillItem.id )">
                            <input type="hidden" name="_method" value="PUT">
                            <div class="modal-body">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control" id="title" placeholder="Enter title" v-model="fillItem.title">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control" id="description" rows="3" placeholder="Enter description" v-model="fillItem.description"></textarea>
                                        </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.getItems();
        },
        data: () => ({
            items: [],
            newItem: { 'title': '', 'description': ''},
            fillItem: { 'title': '', 'description': '', 'id': ''}
        }),
        methods: {
            getItems() {
                axios.get( 'vue-items' ).then( response => {
                    let answer = response.data;
                    this.items = answer.items;
                })
            },
            createItem() {
                let input = this.newItem;

                axios.post('vue-items', input).then( (response) => {

                    this.items.push(response.data);
                    this.newItem = {'title': '', 'description': ''};
                    $('#create-item').modal('hide');

                }).catch( (error) => {
                    console.log( error.response.data )
                })
            },
            editItem( item ) {
                let edit = this.fillItem;

                edit.title = item.title;
                edit.description = item.description;
                edit.id = item.id;

                $("#edit-item").modal('show');
            },
            updateItem( id ){
                let input = this.fillItem;

                axios.put('vue-items/' + id, input).then( (response)=> {

                    this.getItems();
                    this.fillItem = {'title': '', 'description': '', 'id': ''};
                    $('#edit-item').modal('hide');

                }).catch( (error)=> {
                    console.log( error.response.data )
                })
            },
            deleteItem( item ) {
                axios.delete('vue-items/' + item.id).then( (response) => {
                    this.getItems();
                });
            }
        }
    }
</script>