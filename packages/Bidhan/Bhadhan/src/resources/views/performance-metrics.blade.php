@extends('Bhadhan::layouts.app')

@section('title', 'DB - SCHEMA | Performance Metrics')

@section('content')
    <div id="vue_app">
        <div class="container-fluid">
            <div class="col-12">
                <table class="table mt-1 table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" colspan="2" class="text-center connection-name"><span
                                    v-text="'Your Total Schema Size : ' + totalSchemaSize"></span></th>
                        </tr>
                        <tr class="f-08">
                            <th class="lh-08">Table Name</th>
                            <th class="lh-08">Total Allocated Space</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="(tableWithSize,tableWithSizeKey) in tableWithSizes">
                            <tr class="f-08 text-white">
                                <td v-text="tableWithSize.table_name" class="lh-06"></td>
                                <td v-text="tableWithSize.total_size" class="lh-06"></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
            <div class="col-12">
                <table class="table mt-1 table-bordered">
                    <thead class="thead-dark">
                        <tr class="f-08">
                            <th class="lh-08">Table Schema</th>
                            <th class="lh-08">View Name</th>
                            <th class="lh-08">Updateable</th>
                            <th class="lh-08">Check Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="(dbView,dbViewKey) in dbViews">
                            <tr class="f-08 text-white">
                                <td v-text="dbView.table_schema" class="lh-06"></td>
                                <td v-html="'<i>' + dbView.view_name + '</i>'" class="lh-06 cursor-pointer"
                                    data-toggle="modal" data-target="#exampleModal" @click="openModal(dbViewKey)"></td>
                                <td v-text="dbView.is_updatable == 'NO' ? '❌': '✅'" class="lh-06"></td>
                                <td v-html="'<i>' + dbView.check_option+'</i>'" class="lh-06"></td>
                            </tr>
                        </template>
                    </tbody>
                </table>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">View Definitions :</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <p v-html="modalDbView?.view_definition">
                                    </p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        new Vue({
            el: "#vue_app",
            data: {
                totalSchemaSize: null,
                tableWithSizes: [],
                dbViews: [],
                modalDbView: {}
            },
            methods: {
                loadSchema: function() {
                    let vm = this;
                    axios.get("{{ route('bhadhan-db-manager.performance') }}", {
                        params: {
                            isAjax: true,
                        }
                    }).then(function(res) {
                        vm.totalSchemaSize = res.data?.totalSchemaSize[0]?.total_size;
                        vm.tableWithSizes = res.data?.tableWithSizes;
                        vm.dbViews = res.data?.dbViews;
                        console.log(vm.totalSchemaSize);
                    }).catch(function(err) {
                        console.log(err);
                    });
                },
                openModal: function(dbViewKey) {
                    let vm = this;
                    console.log('ok');
                    vm.modalDbView = vm.dbViews[dbViewKey];
                }
            },
            mounted() {
                let vm = this;
                vm.loadSchema();
            }
        });
    </script>
@endsection
