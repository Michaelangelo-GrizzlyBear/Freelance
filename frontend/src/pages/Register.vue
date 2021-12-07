<template>
  <q-layout>
    <q-page-container>
      <q-page class="flex flex-center">
        <q-card
          class="login-form bg-grey-1 large-screen-only"
          v-bind:style="
            $q.platform.is.mobile ? { width: '70%' } : { width: '50%' }
          "
        >
          <q-card-section>
            <q-avatar
              size="74px"
              class="absolute"
              style="top: 0; right: 45%; transform: translateY(-50%)"
            >
              <img
                src="https://image.flaticon.com/icons/png/512/3456/3456400.png"
              />
            </q-avatar>
            <div class="row no-wrap items-center">
              <div class="col text-h6 q-mt-sm text-center ellipsis">
                Register
              </div>
            </div>
            <q-separator />
          </q-card-section>

          <q-card-section>
            <!-- DESKTOP -->
            <q-form
              class="q-gutter-lg"
              method="post"
              enctype="multipart/form-data"
            >
              <div class="row">
                <q-input class="col-4 q-pa-sm" outlined label="Lastname" />
                <q-input class="col-4 q-pa-sm" outlined label="Firstname" />
                <q-input class="col-4 q-pa-sm" outlined label="Middlename" />
                <q-input class="col-4 q-pa-sm" outlined label="Suffix" />
                <q-input class="col-4 q-pa-sm" outlined label="Birthdate" />
                <q-input class="col-4 q-pa-sm" outlined label="Birthplace" />
                <q-input class="col-4 q-pa-sm" outlined label="Age" />
                <q-input class="col-4 q-pa-sm" outlined label="Gender" />
                <q-input
                  class="col-4 q-pa-sm"
                  outlined
                  label="Contact Number"
                />
                <q-input
                  class="col-6 q-pa-sm"
                  outlined
                  label="Emergency"
                  hint="Person to Contact incase of Emergency"
                />
                <q-input
                  class="col-6 q-pa-sm"
                  outlined
                  label="Contact"
                  hint="Contact number incase of Emergency"
                />
                <q-input class="col-6 q-pa-sm q-mt-md" outlined label="Email" />
                <q-input
                  class="col-6 q-pa-sm q-mt-md"
                  outlined
                  label="Password"
                  autocomplete="current-password"
                />
              </div>
              <div>
                <q-btn
                  class="full-width"
                  label="Register"
                  type="button"
                  color="positive"
                  @click="loginNotify"
                />
              </div>
              <!-- <div class="text-right">
                  Already have an Account? <q-btn dense outline color="primary" label="Login" />
              </div> -->
            </q-form>
          </q-card-section>
        </q-card>

        <!-- MOBILE  -->
        <q-card
          class="login-form bg-grey-1 small-screen-only"
          v-bind:style="
            $q.platform.is.mobile ? { width: '95%' } : { width: '95%' }
          "
        >
          <q-card-section>
            <q-avatar
              size="74px"
              class="absolute"
              style="top: 0; right: 45%; transform: translateY(-50%)"
            >
              <img
                src="https://image.flaticon.com/icons/png/512/3456/3456400.png"
              />
            </q-avatar>
            <div class="row no-wrap items-center">
              <div class="col text-h6 q-mt-sm text-center ellipsis">
                Register
              </div>
            </div>
            <q-separator />
          </q-card-section>
          <q-card-section>
            <q-form
              @submit="creatingRegistration()"
              method="post"
              enctype="multipart/form-data"
            >
              <div class="row">
                <q-input
                  class="col-12 q-pa-sm"
                  outlined
                  label="Lastname"
                  v-model="userData.lastname"
                  :rules="[(val) => !!val || 'Lastname is required']"
                />
                <q-input
                  class="col-12 q-pa-sm"
                  outlined
                  label="Firstname"
                  v-model="userData.firstname"
                  :rules="[(val) => !!val || 'Firstname is required']"
                />
                <q-input
                  class="col-12 q-pa-sm"
                  outlined
                  label="Middlename"
                  v-model="userData.middlename"
                  :rules="[(val) => !!val || 'Middlename is required']"
                />
                <q-input
                  class="col-12 q-pa-sm"
                  outlined
                  label="Suffix"
                  v-model="userData.suffix"
                  :rules="[(val) => !!val || 'Suffix is required']"
                />
                <q-input
                  class="col-12 q-pa-sm"
                  outlined
                  mask="date"
                  label="Date"
                  :rules="['date']"
                  v-model="userData.birthDate"
                >
                  <template v-slot:append>
                    <q-icon name="event" class="cursor-pointer">
                      <q-popup-proxy
                        ref="qDateProxy"
                        transition-show="scale"
                        transition-hide="scale"
                      >
                        <q-date v-model="userData.birthDate">
                          <div class="row items-center justify-end">
                            <q-btn
                              v-close-popup
                              label="Close"
                              color="primary"
                              flat
                            />
                          </div>
                        </q-date>
                      </q-popup-proxy>
                    </q-icon>
                  </template>
                </q-input>
                <q-input
                  class="col-12 q-pa-sm"
                  outlined
                  label="Birthplace"
                  v-model="userData.birthPlace"
                  :rules="[(val) => !!val || 'Birthplace is required']"
                />
                <q-input
                  class="col-12 q-pa-sm"
                  outlined
                  type="number"
                  label="Age"
                  v-model="userData.age"
                  :rules="[(val) => !!val || 'Age is required']"
                />
                <q-select
                  class="col-12 q-pa-sm"
                  outlined
                  v-model="userData.sex"
                  :options="genderOptions"
                  label="Gender"
                  :rules="[(val) => !!val || 'Gender is required']"
                />

                <q-input
                  class="col-12 q-pa-sm"
                  outlined
                  type="number"
                  label="Contact Number"
                  v-model="userData.contact"
                  :rules="[(val) => !!val || 'Contact number is required']"
                />
                <q-input
                  class="col-12 q-pa-sm"
                  outlined
                  label="Emergency Contact Person"
                  v-model="userData.emergencyContact"
                  :rules="[(val) => !!val || 'Emergency is required']"
                />
                <q-input
                  class="col-12 q-pa-sm"
                  outlined
                  label="Contact No."
                  v-model="userData.emergencyNo"
                  type="number"
                  :rules="[(val) => !!val || 'Contact is required']"
                />
                <q-input
                  class="col-12 q-pa-sm q-mt-md"
                  outlined
                  label="Email"
                  v-model="userData.email"
                  :rules="[(val) => !!val || 'Email is required']"
                />
                <q-input
                  class="col-12 q-pa-sm q-mt-md"
                  outlined
                  label="Password"
                  type="password"
                  v-model="userData.password"
                  :rules="[(val) => !!val || 'Password is required']"
                  autocomplete="current-password"
                />
                <!-- <q-file
                  class="col-12 q-pa-sm q-mt-md"
                  v-model="userData.image"
                  label="Profile Picture"
                  accept=".jpg, .jpeg, .png, image/*"
                >
                  <template v-slot:prepend>
                    <q-icon name="attach_file" />
                  </template>
                </q-file> -->
                <!-- <img
                  class="col-12 q-pa-sm q-mt-md"
                  :src="imageUrl"
                  width="250"
                  height="150"
                />
                <q-input
                  class="col-12 q-pa-sm q-mt-md"
                  color="teal-4"
                  type="file"
                  accept="image/*, jpeg, jpg, png"
                  @change="imagePicking"
                  @onfocus="resetimginput()"
                  ref="imginput"
                  lazy-rules
                  :rules="[
                    (val) =>
                      (imageUrl && imageUrl.length > 0) ||
                      'Please attach a Picture',
                  ]"
                >
                  <template v-slot:prepend>
                    <q-icon name="attach_file" />
                  </template>
                </q-input> -->
              </div>
              <div>
                <q-btn
                  class="full-width"
                  label="Register"
                  type="submit button"
                  color="positive"
                />
              </div>
            </q-form>
          </q-card-section>
        </q-card>
        <!-- END OF MOBILE  -->
        <q-dialog v-model="small">
          <q-card style="width: 300px">
            <q-card-section>
              <div class="text-h6 text-center">
                Successfully Registered
                <q-icon class="text-green" name="done_outline" />
              </div>
            </q-card-section>
          </q-card>
        </q-dialog>
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script type="text/javascript"></script>
<script>
import { QSpinnerGears } from "quasar";
import axios from "axios";

export default {
  data() {
    return {
      small: false,
      userData: {
        lastname: "",
        firstname: "",
        middlename: "",
        birthDate: "",
        birthPlace: "",
        suffix: "",
        age: "",
        sex: "",
        contact: "",
        emergencyNo: "",
        emergencyContact: "",
        email: "",
        password: "",
        // image: null,
      },
      imageUrl: null,
      genderOptions: ["Male", "Female"],
      processing: false,
    };
  },
  methods: {
    creatingRegistration() {
      this.$q
        .dialog({
          title: "Confirm Registration?",
          cancel: true,
          persistent: true,
          color: "info",
        })
        .onOk(() => {
          this.register();
        });
    },
    creationOfPatient() {
      const dialog = this.$q.dialog({
        title: "Creating User...",
        message: "0%",
        progress: {
          spinner: QSpinnerGears,
          color: "info",
        },
        persistent: true, // we want the user to not be able to close it
        ok: false, // we want the user to not be able to close it
      });

      // we simulate some progress here...
      let percentage = 0;
      const interval = setInterval(() => {
        percentage = Math.min(100, percentage + Math.floor(Math.random() * 22));

        // we update the dialog
        dialog.update({
          message: `${percentage}%`,
        });

        // if we are done...
        if (percentage === 100) {
          clearInterval(interval);

          dialog.update(
            {
              title: "Successfully Created User",
              progress: false,
              ok: false,
            },
            setTimeout(() => {
              dialog.hide();
              this.$router.push({ name: "Login" });
            }, 1000)
          );
        }
      }, 500);
    },

    async register() {
      let t = this;
      let data = new FormData();
      data.append("lastname", t.userData.lastname);
      data.append("firstname", t.userData.firstname);
      data.append("middlename", t.userData.middlename);
      data.append("birthDate", t.userData.birthDate);
      data.append("birthPlace", t.userData.birthPlace);
      data.append("suffix", t.userData.suffix);
      data.append("sex", t.userData.sex);
      data.append("age", t.userData.age);
      data.append("contact", t.userData.contact);
      data.append("emergencyNo", t.userData.emergencyNo);
      data.append("emergencyContact", t.userData.emergencyContact);
      data.append("email", t.userData.email);
      data.append("password", t.userData.password);

      try {
        axios
          .post("http://127.0.0.1:8000/api/register", data)
          .then((registration) => {
            console.log("Registration", registration);
            this.creationOfPatient();
          });
      } catch (error) {
        console.log(error);
      }
    },
    loginNotify() {
      this.$q.notify({
        message: "Login Successful",
      });
    },
  },
  computed: {},
  mounted() {},
};
</script>

<style>
#particles-js {
  position: absolute;
  width: 100%;
  height: 100%;
  background-repeat: no-repeat;
  background-size: cover;
  background-position: 60% 50%;
}
.normal_gradient {
  background: linear-gradient(145deg, rgb(9, 69, 121) 15%, #b61924 85%);
}
.dark_gradient {
  background: linear-gradient(145deg, rgb(9, 69, 121) 15%, #4c1014 70%);
}
.login-form {
  position: absolute;
}
</style>
