<template>
  <div>
    <q-page class="flex flex-center">
      <div class="q-pa-sm" style="max-width: 600px">
        <div class="q-pa-xs q-mb-md">
          <div class="row">
            <div class="q-pa-md col-6">
              <q-btn
                class="buttonsize"
                style="font-size: 20px"
                icon="event"
                label="Appointment"
                stack
                size="xl"
                color="indigo-10"
                to="/appointment"
              />
            </div>
            <div class="q-pa-md col-6">
              <q-btn
                to="/patient/labtestprep"
                class="buttonsize"
                style="font-size: 20px"
                icon="medical_services"
                label="LabTest"
                stack
                size="xl"
                color="indigo-10"
              />
            </div>
            <div class="q-pa-md col-6">
              <q-btn
                to="/patient/doctors"
                class="buttonsize"
                style="font-size: 20px"
                icon="biotech"
                label="Doctor's"
                stack
                size="xl"
                outline
                color="indigo-10"
              />
            </div>
            <div class="q-pa-md col-6">
              <q-btn
                class="buttonsize"
                style="font-size: 20px"
                icon="location_on"
                label="Branches"
                stack
                size="xl"
                outline
                color="indigo-10"
              />
            </div>
            <div class="q-pa-md col-6">
              <q-btn
                class="buttonsize"
                style="font-size: 20px"
                icon="airport_shuttle"
                label="Home Service"
                stack
                size="xl"
                color="red-9"
              />
            </div>
            <div class="q-pa-md col-6">
              <q-btn
                class="buttonsize"
                style="font-size: 20px"
                icon="article"
                label="News"
                stack
                size="xl"
                color="red-9"
              />
            </div>
            <div class="q-pa-md col-6">
              <q-btn
                class="buttonsize"
                style="font-size: 20px"
                icon="money"
                label="Price"
                stack
                size="xl"
                outline
                color="red-10"
              />
            </div>
            <div class="q-pa-md col-6">
              <q-btn
                class="buttonsize"
                style="font-size: 20px"
                icon="feed"
                label="Forms"
                stack
                size="xl"
                outline
                color="red-10"
              />
            </div>
            <div class="q-pa-md col-12">
              <q-btn
                to="/profile"
                class="buttonsize"
                style="font-size: 20px"
                icon="account_circle"
                label="Profile"
                stack
                size="xl"
                color="indigo-10"
              />
            </div>
          </div>
        </div>
      </div>
    </q-page>
  </div>
</template>

<script>
export default {
  data() {
    return {};
  },
  methods: {},
  mounted() {
    // console.log("Comp", Store);
    // console.log("Comp", Store.getters.authPermissions == "1");
    // console.log(this.$session.get("user").id);
    // // console.log(sessionStorage.getItem("user"));
    // console.log(this.$session.get("user"));
    console.log(localStorage.getItem("Bearer"));
  },
};
</script>
<style scoped>
.buttonsize {
  font-size: 3%;
  width: 100%;
  height: 95%;
}
.nwd-logo {
  margin-bottom: 25px;
}
</style>