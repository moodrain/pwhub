@extends('layout.frame')

@section('title', 'Dashboard')

@section('main')
    <el-row id="app">
        <el-col :lg="18">
            <br />

            <el-card v-if="apps.length === 0" :lg="4">
                No Data
            </el-card>

            <el-card v-if="apps.length > 0">
                <el-collapse v-model="activeName" accordion>

                    <el-collapse-item v-for="app in apps" :title="app.name" :name="app.name" style="font-size: 1.2em">
                        <div v-for="(account, index) in app.accounts" class="account-p" style="height: 80px;line-height: 80px;">
                            <el-divider></el-divider>
                            <p>
                                <span style="display: inline-block;width: 70%;padding-left: 2%;font-size: 1.1em;overflow-x: scroll">
                                    <span style="display: inline-block;width: max-content;">@{{ account.username }}</span>
                                </span>
                                <span style="display: inline-block;float: right;width: 20%;text-align: right;padding-right: 2%;">
                                    <el-button class="clipboard-btn" icon="el-icon-document" :data-clipboard-text="account.password"></el-button>
                                </span>
                            </p>
                        </div>
                    </el-collapse-item>

                </el-collapse>
            </el-card>
        </el-col>
    </el-row>
@endsection

@section('script')
<script>
new Vue({
    el: '#app',
    data () {
        return {
            @include('piece.data')
            menuActive: 'dashboard',
            activeName: '',
            apps: @json($apps),
        }
    },
    method: {
        @include('piece.method')
    },
    mounted() {
        @include('piece.init')
    },
})
</script>
@endsection

@section('style')
<style>
    .el-collapse-item__header {
        font-size: .8em;
    }
    .el-collapse-item__content {
        padding-bottom: 40px !important;
    }
    .el-divider {
        margin: 0 !important;
    }
    .account-p:hover {
        background: #09faf3;
    }
</style>
@endsection