<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          icon="menu"
          aria-label="Menu"
          @click="leftDrawerOpen = !leftDrawerOpen"
        />

        <q-toolbar-title> Quasar App </q-toolbar-title>
      </q-toolbar>
    </q-header>

    <q-drawer
      v-model="leftDrawerOpen"
      show-if-above
      :width="200"
      :breakpoint="400"
    >
      <q-scroll-area
        style="
          height: calc(100% - 150px);
          margin-top: 150px;
          border-right: 1px solid #ddd;
        "
      >
        <q-list padding class="q-pa-sm">
          <q-item clickable v-ripple>
            <q-item-section avatar>
              <q-icon name="dashboard" />
            </q-item-section>

            <q-item-section> DASHBOARD </q-item-section>
          </q-item>

          <q-item to="/schedules" clickable v-ripple>
            <q-item-section avatar>
              <q-icon name="today" />
            </q-item-section>

            <q-item-section> SCHEDULE </q-item-section>
          </q-item>

          <q-item to="/doctors" clickable v-ripple>
            <q-item-section avatar>
              <q-icon name="account_box" />
            </q-item-section>

            <q-item-section> DOCTORS </q-item-section>
          </q-item>

          <q-expansion-item expand-separator icon="category" label="ITEMS">
            <q-item to="/items" clickable v-ripple>
              <q-item-section avatar>
                <q-icon name="list_alt" />
              </q-item-section>

              <q-item-section>ITEMS</q-item-section>
            </q-item>

            <q-item to="/packageitem" clickable v-ripple>
              <q-item-section avatar>
                <q-icon name="inventory_2" />
              </q-item-section>

              <q-item-section>PACKAGE ITEMS</q-item-section>
            </q-item>
          </q-expansion-item>

          <q-item clickable v-ripple>
            <!-- <q-item-section avatar> -->
            <!-- <q-icon name="logout" /> -->
            <q-btn
              @click="LoggingOut"
              class="full-width"
              icon="logout"
              color="white"
              flat
              text-color="black"
              label="Logout"
            />
            <!-- </q-item-section> -->

            <!-- <q-item-section> Logout </q-item-section> -->
            <!-- <q-btn
              class="full-width"
              color="white"
              flat
              text-color="black"
              label="Logout"
            /> -->
          </q-item>
        </q-list>
      </q-scroll-area>

      <q-img
        class="absolute-top text-center"
        src="https://cdn.quasar.dev/img/material.png"
        style="height: 150px"
      >
        <div class="absolute-bottom bg-transparent">
          <q-avatar size="56px" class="q-mb-sm">
            <img src="https://cdn.quasar.dev/img/boy-avatar.png" />
          </q-avatar>
          <div class="text-weight-bold">
            {{ this.myProfile.lastname + ", " + this.myProfile.firstname }}
          </div>
          <div>{{ this.myProfile.email }}</div>
        </div>
      </q-img>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
export default {
  name: "MainLayout",
  data() {
    return {
      leftDrawerOpen: false,
      myProfile: {},
    };
  },
  beforeCreate: function () {
    // if (!this.$session.exists()) {
    //   this.$router.push("/login");
    // } else if (!this.$session.get("user").id == 1) {
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
      // this.$session.destroy();
      // this.$router.push({ name: "Login" });
    },
  },
  mounted() {
    try {
      const bearerToken = localStorage.getItem("Bearer");
      // console.log("Profile");
      this.$axios
        .get("http://127.0.0.1:8000/api/myProfile", {
          headers: {
            Authorization: `Bearer ${bearerToken}`,
          },
        })
        .then((response) => {
          // console.log("My Profile", response);
          this.myProfile = response.data;
          console.log("Super Admin", this.myProfile);
        });
    } catch (error) {
      console.log(error);
    }
  },
};
</script>