@extends('Bhadhan::layouts.app')

@section('title', 'DB - SCHEMA | Performance Metrics')

@section('content')
    <div id="vue_app">
        <div class="container-fluid">
            <div class="col-6">
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
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        new Vue({
            el: "#vue_app",
            data: {
                totalSchemaSize: null,
                tableWithSizes: []
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
                        console.log(vm.totalSchemaSize);
                    }).catch(function(err) {
                        console.log(err);
                    });
                }
            },
            mounted() {
                let vm = this;
                vm.loadSchema();
            }
        });
    </script>
@endsection
