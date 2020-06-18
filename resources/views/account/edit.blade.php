@extends('layout.frame')

@include('piece.edit-title')

@section('main')
    <el-card style="width: 500px;">
        <el-form label-width="80px">
            <x-edit-id :d="$d"></x-edit-id>
            <x-input exp="model:form.username;label:UserName"></x-input>
            <x-input exp="model:form.password;label:Password;type:password"></x-input>
            <x-select exp="model:form.applicationId;label:App;data:applications;key:id;selectLabel:name;value:id" />
            <x-input exp="model:form.note;label:Note"></x-input>
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
                    username: '{{ bv('username') }}',
                    password: '{{ bv('password') }}',
                    applicationId: {{ bv('applicationId', null) }},
                    note: '{{ bv('note') }}',
                },
                applications: @json(\App\Models\Application::query()->get(['id', 'name'])),
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
