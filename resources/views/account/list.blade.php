@extends('layout.frame')

@include('piece.list-title')

@section('main')
<el-card>
    <el-form inline>
        <x-input exp="model:search.id;pre:ID" />
        <x-select exp="model:search.applicationId;label:App;data:applications;key:id;selectLabel:name;value:id" />
        <x-input exp="model:search.username;pre:UserName" />
        <x-input exp="model:search.note;pre:Note" />
        <x-sort />
        <x-list-head-btn :m="$m" />
    </el-form>
</el-card>
<br />
<el-card>
    <el-table :data="list" height="560" border  @selection-change="selectChange">
        <el-table-column type="selection" width="55"></el-table-column>
        <el-table-column prop="id" label="ID" width="60"></el-table-column>
        <el-table-column prop="application.name" label="App"></el-table-column>
        <el-table-column prop="username" label="UserName"></el-table-column>
        <el-table-column label="Password" width="100">
            <template slot-scope="scope">
                <el-popover placement="bottom" trigger="click" content="Password Copied!">
                    <el-button slot="reference" class="clipboard-btn" icon="el-icon-document" :data-clipboard-text="scope.row.password"></el-button>
                </el-popover>
            </template>
        </el-table-column>
        <el-table-column prop="note" label="Note"></el-table-column>
        <el-table-column prop="createdAt" label="createdAt" width="160"></el-table-column>
        <x-list-body-col :m="$m" />
    </el-table>
    <x-pager />
</el-card>
@endsection

@section('script')
<script>
    new Vue({
        el: '#app',
        data () {
            return {
                @include('piece.list-data')
                applications: @json(\App\Models\Application::query()->get(['id', 'name'])),
            }
        },
        methods: {
            @include('piece.list-method')
        },
        mounted() {
            @include('piece.init')
        }
    })
</script>
@endsection