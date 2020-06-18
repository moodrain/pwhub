<el-menu-item index="dashboard" @click="$to('/'), {}, true">Dashboard</el-menu-item>

<el-submenu index="account">
    <template slot="title">Account</template>
    <el-menu-item index="account-list" @click="$to('/account/list', {}, true)">Account List</el-menu-item>
    <el-menu-item index="account-edit" @click="$to('/account/edit')">Account Edit</el-menu-item>
</el-submenu>

<el-submenu index="application">
    <template slot="title">App</template>
    <el-menu-item index="application-list" @click="$to('/application/list', {}, true)">App List</el-menu-item>
    <el-menu-item index="application-edit" @click="$to('/application/edit', {}, true)">App Edit</el-menu-item>
</el-submenu>
