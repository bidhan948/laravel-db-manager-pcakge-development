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
                    <label for="raw_sql mt-1 sql-label">Enter Your SQL Query:</label>
                    <div id="editor" class="editor" contenteditable="true" @input="updateRawSql" ref="editor"></div>
                </div>
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
                rawSql: ""
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
