@extends('Bhadhan::layouts.app')

@section('title', 'DB - SCHEMA | SQL Editor')

@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.25.0/themes/prism-tomorrow.min.css" rel="stylesheet" />
    <style>
        .editor {
            background-color: #2d2d2d;
            color: #f8f8f2;
            padding: 10px;
            border-radius: 5px;
            font-family: monospace;
            min-height: 100px;
            max-height: 500px;
            overflow-y: auto;
            white-space: pre-wrap;
            outline: none;
        }
    </style>
    <div id="vue_app">
        <div class="container-fluid">
            <div class="col-12">
                <div class="form-group">
                    <p class="sql-label mt-1">Enter Your SQL Query :</p>
                    <div id="editor" class="editor" contenteditable="true" @input="updateRawSql" @keydown="handleKeydown"
                        ref="editor"></div>
                </div>
            </div>
            <div :class="sqlData.length ? 'sql-table-div col-12' : 'col-12'" v-if="sqlData">
                <table class="table mt-1 table-bordered" style="overflow-x: scroll;">
                    <thead class="thead-dark">
                        <tr>
                            <template v-for="(columnName,columnNameKey) in columnNames">
                                <th class="f-08" v-text="columnName"></th>
                            </template>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="f-08 text-white" v-for="(row,rowKey) in sqlData">
                            <template v-for="(columnValue,columnValueKey) in columnNames">
                                <td class="f-08" v-html="row[columnValue] ? row[columnValue] :'<i>'+null+'</i>' "></td>
                            </template>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.25.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.25.0/components/prism-sql.min.js"></script>
    <script>
        new Vue({
            el: "#vue_app",
            data: {
                rawSql: "",
                columnNames: [],
                sqlData: []
            },
            methods: {
                updateRawSql: function() {
                    const editor = this.$refs.editor;
                    this.rawSql = editor.innerText;
                    this.$nextTick(function() {
                        const highlighted = Prism.highlight(this.rawSql, Prism.languages.sql, 'sql');
                        editor.innerHTML = highlighted;
                        this.setCaretToEnd(editor);
                    });
                },
                setCaretToEnd: function(editor) {
                    const range = document.createRange();
                    const sel = window.getSelection();
                    range.selectNodeContents(editor);
                    range.collapse(false);
                    sel.removeAllRanges();
                    sel.addRange(range);
                    editor.focus();
                },
                handleKeydown: function(event) {
                    let vm = this;
                    if (event.ctrlKey && event.key === 'Enter') {
                        event.preventDefault();
                        vm.submitQuery();
                    }
                },
                submitQuery: function() {
                    let vm = this;
                    axios.post("{{ route('bhadhan-db-manager.sqlToData') }}", {
                        rawSql: vm.rawSql
                    }).then(function(res) {
                        vm.columnNames = res.data.columnNames;
                        vm.sqlData = res.data.fetchFromSql;
                        console.log(res);
                    }).catch(function(err) {
                        console.log(err);
                    });
                }
            },
            mounted() {
                this.$nextTick(function() {
                    Prism.highlightAll();
                });
            }
        });
    </script>
@endsection
