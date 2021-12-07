<template>
  <q-layout view="lHh Lpr lFf">
    <q-header bordered>
      <q-toolbar class="">
        <q-toolbar-title class="text-center">
          <div class="col-12">
            <q-btn
              to="/patient"
              class="q-mr-md"
              icon="home"
              dense
              outline
              color="white"
            />
          </div>
        </q-toolbar-title>
        <q-btn flat round dense icon="logout" @click.prevent="LoggingOut" />
      </q-toolbar>
    </q-header>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
import axios from "axios";

export default {
  name: "MainLayout",
  data() {
    return {
      bearerToken: localStorage.getItem("Bearer"),
    };
  },
  beforeCreate: function () {
    // if (!this.$cookies.exists() && !this.$cookies.get("laravel_session")) {
    //   this.$router.push("/login");
    // } else if (!this.$cookies.get("laravel_session").id == 6) {
    //   this.$cookies.destroy();
    //   this.$router.push("/login");
    // }
    // // if (!this.$session.exists() && !this.$session.get('')) {
    //   this.$router.push("/login");
    // } else if (!this.$session.get("user").id == 6) {
    //   this.$session.destroy();
    //   this.$router.push("/login");
    // }
  },
  methods: {
    LoggingOut() {
      this.$q
        .dialog({
          title: "Do you wish to Logout?",
          cancel: true,
          persistent: true,
        })
        .onOk(() => {
          this.logout();
        });
    },
    logout() {
      this.$axios
        .post("http://127.0.0.1:8000/api/signout", {
          headers: {
            Accept: "application/json",
            Authorization: "Bearer " + this.bearerToken,
          },
        })
        .then((res) => {
          console.log("Logout", res);
          localStorage.destroy("Bearer");
          this.$router.push({ name: "Login" });
        })
        .catch((err) => {
          console.log("Error from Patient Layout", err);
        });
    },
  },
};
</script>
<style scoped>
.nwd-logo {
  width: 85%;
  height: 80%;
  margin-top: 15px;
  margin-left: auto;
  margin-right: auto;
  margin-bottom: 15px;
}
</style>
