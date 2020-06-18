@extends('layout.frame')

@include('piece.edit-title')

@section('main')
    <el-card style="width: 500px;">
        <el-form label-width="80px">
            <x-edit-id :d="$d"></x-edit-id>
            <x-input exp="model:form.name;label:Name"></x-input>
            <x-input exp="model:form.site;label:Site"></x-input>
            <x-edit-submit :d="$d"></x-edit-submit>
        </el-form>
    </el-card>
@endsection

@section('script')
<script>
    let vue = new Vue({
        el: '#app',
        data () {
            return {
                @include('piece.edit-data')
                form: {
                    id: {{ bv('id', null) }},
                    name: '{{ bv('name') }}',
                    site: '{{ bv('site') }}',
                },
            }
        },
        methods: {
            @include('piece.edit-method')
        },
        mounted() {
            @include('piece.init')
        }
    })
    $enter(() => $submit(vue.form))
</script>
@endsection
