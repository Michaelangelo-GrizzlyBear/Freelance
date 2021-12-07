<template>
  <q-layout>
    <q-page-container>
      <q-page class="flex flex-center">
        <div id="particles-js"></div>

        <q-card
          class="login-form large-screen-only"
          v-bind:style="
            $q.platform.is.desktop ? { width: '35%' } : { width: '80%' }
          "
        >
          <q-card-section>
            <q-avatar
              size="74px"
              class="absolute"
              style="top: 0; right: 25px; transform: translateY(-50%)"
            >
              <img
                src="https://image.flaticon.com/icons/png/512/4784/4784546.png"
              />
            </q-avatar>
            <div class="row no-wrap items-center">
              <div class="col text-h6 ellipsis">Login</div>
            </div>
          </q-card-section>
          <q-card-section>
            <q-form class="q-gutter-md" @click="loggingIn">
              <q-input outlined label="Email" v-model="form.email" />

              <q-input
                type="password"
                outlined
                v-model="form.password"
                label="Password"
                autocomplete="off"
              />

              <div>
                <q-btn
                  class="full-width"
                  label="Login"
                  type="button"
                  color="primary"
                />
              </div>
            </q-form>
          </q-card-section>
        </q-card>

        <!-- Login Mobile  -->
        <q-card
          class="login-form-mobile small-screen-only"
          v-bind:style="
            $q.platform.is.mobile ? { width: '80%' } : { width: '70%' }
          "
        >
          <q-card-section>
            <q-avatar
              class="nwd-logo-mobile absolute"
              style="top: 0; right: 55px; transform: translateY(-50%)"
            >
            </q-avatar>
          </q-card-section>
          <q-card-section>
            <q-form class="q-gutter-md" @submit="loggingIn">
              <q-input outlined v-model="form.email" label="Email" />
              <q-input
                type="password"
                outlined
                v-model="form.password"
                label="Password"
                autocomplete="off"
              />

              <div>
                <q-btn
                  class="full-width"
                  label="Login"
                  type="submit button"
                  color="primary"
                />
              </div>
            </q-form>
          </q-card-section>
        </q-card>
      </q-page>
    </q-page-container>
  </q-layout>
</template>
<script>
import axios from "axios";

export default {
  data() {
    return {
      user: {},
      form: {
        email: "",
        password: "",
      },
    };
  },
  methods: {
    loggingIn() {
      this.login();
    },
    login: function () {
      let t = this;
      let email = t.form.email;
      let password = t.form.password;

      axios
        .get("http://127.0.0.1:8000/sanctum/csrf-cookie")
        .then((response) => {
          axios
            .post("http://127.0.0.1:8000/api/login", { email, password })
            .then((res) => {
              console.log("From Login Layout", res);
              console.log("User Role", res.data.user.role);
              if (res.data.user.role == 1) {
                this.$router.push({ name: "HomeSuperAdmin" });
              } else if (res.data.user.role == 2) {
                this.$router.push({ name: "HomeAdmin" });
              } else if (res.data.user.role == 3) {
                this.$router.push({ name: "HomeMedTech" });
              } else if (res.data.user.role == 4) {
                this.$router.push({ name: "HomeDoctor" });
              } else if (res.data.user.role == 5) {
                this.$router.push({ name: "HomeLabHead" });
              } else if (res.data.user.role == 6) {
                this.$router.push({ name: "HomePatient" });
              }
              localStorage.setItem("Bearer", res.data.token);
              this.user = res.data.user;
            });
          console.log(response);
        });
    },
  },
};
</script>

<style>
.login-form {
  position: absolute;
}
.login-form-mobile {
  position: relative;
}
.nwd-logo-mobile {
  width: 90%;
  left: 10%;
  margin-top: 12px;
  border-radius: 0;
}
</style>
