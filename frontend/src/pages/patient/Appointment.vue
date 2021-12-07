<template>
  <div>
    <q-page>
      <div>
        <div class="q-pa-md" style="max-width: 100%">
          <q-card>
            <q-tabs
              v-model="tab"
              dense
              class="text-grey"
              active-color="primary"
              indicator-color="primary"
              align="justify"
            >
              <q-tab name="appointment" label="History" />
              <q-tab name="walkin" label="Walk-in" />
              <q-tab name="homeservice" label="Home Service" />
              <q-tab name="inquiry" label="Inquiry" />
            </q-tabs>

            <q-separator />

            <q-tab-panels v-model="tab" animated>
              <q-tab-panel name="appointment" class="text-center">
                <!-- <div class="text-h6 q-mb-md text-center">
                  Appointment History
                </div> -->
                <q-separator />
                <div class="q-pa-md">
                  <q-list
                    v-for="myAppointment in myAppointments"
                    v-bind:key="myAppointment.id"
                    bordered
                    class="q-my-md"
                  >
                    <q-card class="my-card" flat square>
                      <q-card-section horizontal>
                        <q-card-section class="q-pt-xs">
                          <q-item-label class="text-h5 q-pt-sm q-pl-sm">{{
                            myAppointment.type
                          }}</q-item-label>

                          <q-item-label class="q-pl-sm" caption>
                            <div v-if="myAppointment.created_at">
                              {{ changingDateFormat }}
                            </div>
                            <div v-else>
                              {{ changingDateFormat }}
                            </div>
                          </q-item-label>
                          <!-- <q-item-label class="q-pl-sm" caption> 
                            Type
                            {{ myAppointment.type }}
                            </q-item-label>  -->

                          <!-- <q-item-label
                            v-if="myAppointment.branch"
                            class="q-pl-sm"
                            caption
                          >
                            {{ myAppointment.branch }}
                          </q-item-label> -->

                          <!-- <q-item-label class="column items-end">
                            <img
                              :src="`http://127.0.0.1:8000/images/${myAppointment.file}`"
                              width="300"
                              height="300"
                            />
                          </q-item-label> -->

                          <q-item-label class="column items-end">
                            <q-btn
                              class="q-pa-sm"
                              icon="image"
                              color="primary"
                              outline
                              label="Download File"
                              @click="showPhoto(myAppointment)"
                            />
                          </q-item-label>

                          <div v-if="myAppointment.test" class="text-caption">
                            Laboratory Tests
                          </div>
                          <div
                            v-if="myAppointment.test"
                            class="text-body2 text-black q-pa-sm"
                            style="width: 90%"
                          >
                            {{ myAppointment.test }}
                          </div>
                          <div v-if="myAppointment.date" class="text-caption">
                            Scheduled Date:
                          </div>
                          <div
                            v-if="myAppointment.date"
                            class="text-body2 text-black q-pa-sm"
                          >
                            {{ myAppointment.date }}
                          </div>
                          <div class="text-caption">Other concerns</div>
                          <div class="text-body2 text-black q-pa-sm">
                            {{ myAppointment.otherconcerns }}
                          </div>

                          <div>
                            <div class="text-caption">Status</div>
                            <div
                              v-if="myAppointment.status == 'PENDING'"
                              class="text-text-body2 text-warning q-pl-md"
                            >
                              {{ myAppointment.status }}
                            </div>
                            <div
                              v-else
                              class="text-text-body2 text-positive q-pl-md"
                            >
                              {{ myAppointment.status }}
                            </div>
                          </div>
                        </q-card-section> </q-card-section
                      ><q-dialog
                        v-model="imagePopup"
                        v-bind:key="myAppointment.id"
                        persistent
                      >
                        <q-card>
                          <q-bar>
                            <q-icon name="image" />
                            <div>Image request</div>

                            <q-space />

                            <q-btn dense flat icon="close" v-close-popup>
                              <q-tooltip>Close</q-tooltip>
                            </q-btn>
                          </q-bar>

                          <!-- <q-card-section>
                            <q-img
                              :src="'public/image/' + viewImage"
                              style="max-width: 400px; height: 200px"
                              contain
                            >
                              <div
                                class="
                                  absolute-bottom
                                  text-subtitle1 text-center
                                "
                              >
                                {{ myAppointment.image }}
                              </div>
                            </q-img>
                          </q-card-section> -->
                        </q-card>
                      </q-dialog>
                    </q-card>
                  </q-list>
                </div>
              </q-tab-panel>

              <q-tab-panel name="walkin">
                <div class="text-h4 q-mb-md text-center">Walk-in</div>
                <q-separator />
                <div class="q-pa-md">
                  <q-form
                    @submit="walkInAppointment"
                    method="post"
                    enctype="multipart/form-data"
                    class="q-gutter-md"
                  >
                    <q-input
                      outlined
                      label="Patient name"
                      v-model="walkin.name"
                    />
                    <q-select
                      v-model="walkin.branch"
                      outlined
                      label="Branch"
                      :options="branches"
                    />
                    <q-select
                      outlined
                      label="Select Test"
                      :options="walkinServices"
                      v-model="walkinTest"
                      multiple
                    />
                    <q-input
                      outlined
                      v-model="walkin.date"
                      mask="date"
                      :rules="['date']"
                    >
                      <template v-slot:append>
                        <q-icon name="event" class="cursor-pointer">
                          <q-popup-proxy
                            ref="qDateProxy"
                            transition-show="scale"
                            transition-hide="scale"
                          >
                            <q-date v-model="walkin.date">
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
                      v-model="walkin.time"
                      outlined
                      type="time"
                      hint="Native time"
                    />
                    <input
                      type="file"
                      class="form-control"
                      v-on:change="onChange"
                    />
                    <!-- <q-input
                      outlined
                      type="file"
                      v-model="walkinImage"
                      @change="uploadWalkInImage"
                      accept="image/*, .pdf"
                    /> -->
                    <q-input
                      outlined
                      type="textarea"
                      label="Other Concern/s"
                      v-model="walkin.otherConcerns"
                    />

                    <div class="text-right">
                      <q-btn label="Submit" type="submit" color="positive" />
                    </div>
                  </q-form>
                </div>
              </q-tab-panel>

              <q-tab-panel name="homeservice">
                <div class="text-h4 q-mb-md text-center">Home Service</div>
                <q-separator />
                <div class="q-pa-md">
                  <q-form
                    @submit="homeServiceAppointment"
                    enctype="multipart/form-data"
                    class="q-gutter-md"
                  >
                    <q-input
                      outlined
                      label="Patient name"
                      v-model="homeservice.name"
                    />
                    <q-input
                      outlined
                      label="Address of Home Service"
                      v-model="homeservice.address"
                    />
                    <q-select
                      outlined
                      label="Select Test"
                      :options="homeserviceServices"
                      v-model="homeserviceTest"
                      multiple
                    />
                    <q-input
                      outlined
                      v-model="homeservice.date"
                      mask="date"
                      :rules="['date']"
                    >
                      <template v-slot:append>
                        <q-icon name="event" class="cursor-pointer">
                          <q-popup-proxy
                            ref="qDateProxy"
                            transition-show="scale"
                            transition-hide="scale"
                          >
                            <q-date v-model="homeservice.date">
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
                      v-model="homeservice.time"
                      outlined
                      type="time"
                      hint="Native time"
                    />
                    <q-input
                      outlined
                      type="file"
                      v-model="homeserviceImage"
                      @change="uploadHomeServiceImage"
                      accept="image/*, application/pdf"
                    />

                    <q-input
                      outlined
                      type="textarea"
                      label="Other Concern/s"
                      v-model="homeservice.otherConcerns"
                    />

                    <div class="text-right">
                      <q-btn label="Submit" type="submit" color="positive" />
                    </div>
                  </q-form>
                </div>
              </q-tab-panel>

              <q-tab-panel name="inquiry">
                <div class="text-h4 q-mb-md text-center">Inqury</div>
                <q-separator />
                <div class="q-pa-md">
                  <q-form
                    @submit="inquiryAppointment"
                    enctype="multipart/form-data"
                    class="q-gutter-md"
                  >
                    <q-input
                      outlined
                      type="file"
                      v-model="inquiryImage"
                      @change="uploadInquiryImage"
                      accept="image/*"
                    />
                    <q-input
                      outlined
                      type="textarea"
                      label="Other Concern/s"
                      v-model="inquiry.otherConcerns"
                    />
                    <div class="text-right">
                      <q-btn label="Submit" type="submit" color="positive" />
                    </div>
                  </q-form>
                </div>
              </q-tab-panel>
            </q-tab-panels>
          </q-card>
        </div>
      </div>
    </q-page>
  </div>
</template>

<script>
import axios from "axios";
import moment from "moment";
import download from "downloadjs";
import { QSpinnerFacebook } from "quasar";

export default {
  data() {
    return {
      myProfile: {},
      myAppointments: {},
      imagePopup: false,
      tab: "appointment",
      branches: ["Quezon City "],
      walkinServices: ["Others", "ABO Typing ", "ABO Typing with Rh "],
      viewImage: {},
      walkinImage: "",
      walkinTest: null,
      walkin: {
        name: "",
        branch: "",
        date: "",
        time: "",
        otherConcerns: "",
        type: "Walkin",
      },

      homeserviceServices: ["Others", "ABO Typing "],

      homeserviceImage: "",
      homeserviceTest: null,
      homeservice: {
        name: "",
        address: "",
        date: "",
        time: "",
        otherConcerns: "",
        type: "Home Service",
      },
      inquiryImage: "",
      inquiry: {
        otherConcerns: "",
        type: "Inquiry",
      },
    };
  },
  methods: {
    showNotif(position, mensahe) {
      this.notifications = true;
      const { color, icon } =
        this.alerts[
          Math.floor(Math.random(this.alerts.length) * 10) % this.alerts.length
        ];
      const random = Math.random() * 100;

      this.$q.notify({
        color,
        icon: random > 30 ? icon : null,
        message: mensahe,
        position,
        timeout: Math.random() * 5000 + 3000,
      });

      this.notifications = false;
    },
    showPhoto(myAppointment) {
      // const bearerToken = localStorage.getItem("Bearer");
      // console.log(myAppointment.id, "File ID");

      window.location.replace(
        `http://127.0.0.1:8000/api/my-appointment/${myAppointment.id}`
      );

      // axios
      //   .post(`http://127.0.0.1:8000/api/my-appointment/${myAppointment.id}`, {
      //     responseType: "blob", // important
      //     headers: {
      //       Authorization: `Bearer ${bearerToken}`,
      //     },
      //   })
      //   .then((res) => {
      //     // console.log(res.data, "Resting");
      //     const url = window.URL.createObjectURL(new Blob([res.data]));
      //     const link = document.createElement("a");
      //     link.href = url;
      //     link.setAttribute("download", res.data.file);
      //     document.body.appendChild(link);
      //     link.click();
      //     link.remove();
      //     // console.log(res);
      //   });
    },
    onChange(e) {
      this.walkinImage = e.target.files[0];
    },
    walkInAppointment() {
      let t = this;
      const bearerToken = localStorage.getItem("Bearer");

      this.$q.loading.show({
        spinner: QSpinnerFacebook,
      });

      let data = new FormData();

      data.append("user_id", t.myProfile.id);
      data.append("name", t.walkin.name);
      data.append("branch", t.walkin.branch);
      data.append("test", t.walkinTest);
      data.append("date", t.walkin.date);
      data.append("time", t.walkin.time);
      data.append("file", t.walkinImage);
      data.append("otherconcerns", t.walkin.otherConcerns);
      data.append("type", t.walkin.type);

      axios
        .post("http://127.0.0.1:8000/api/make-appointment", data, {
          headers: {
            Authorization: `Bearer ${bearerToken}`,
            "Content-Type": "multipart/form-data",
          },
        })
        .then(() => {
          this.$q.loading.hide({
            spinner: QSpinnerFacebook,
          });
          this.myAppointmentData();
          (t.walkin.name = ""),
            (t.walkin.branch = ""),
            (t.walkinTest = null),
            (t.walkin.date = ""),
            (t.walkin.time = ""),
            (t.walkinImage = ""),
            (t.walkin.otherConcerns = ""),
            (t.walkin.walkinOption = "");
          this.showNotif("top", "Successfully Created");
        })
        .catch(() => {
          this.$q.loading.hide({
            spinner: QSpinnerFacebook,
          });
        });
    },
    uploadHomeServiceImage(e) {
      let file = e.target.fuk[0];
      let reader = new FileReader();
      reader.onloadend = function (file) {
        this.homeserviceImage = reader.result;
        console.log(this.homeserviceImage);
      };
      reader.readAsDataURL(file);
    },
    homeServiceAppointment() {
      let t = this;
      const bearerToken = localStorage.getItem("Bearer");

      this.$q.loading.show({
        spinner: QSpinnerFacebook,
      });

      let data = new FormData();

      data.append("user_id", t.myProfile.id);
      data.append("name", t.homeservice.name);
      data.append("addressofHomeService", t.homeservice.address);
      data.append("test", t.homeserviceTest);
      data.append("date", t.homeservice.date);
      data.append("time", t.homeservice.time);
      data.append("image", t.homeserviceImage[0]);
      data.append("otherconcerns", t.homeservice.otherConcerns);
      data.append("type", t.homeservice.type);

      axios
        .post("http://127.0.0.1:8000/api/make-appointment", data, {
          headers: {
            Authorization: `Bearer ${bearerToken}`,
            "Content-Type": "multipart/form-data",
          },
        })
        .then(() => {
          this.$q.loading.hide({
            spinner: QSpinnerFacebook,
          });
          (t.homeservice.name = ""),
            (t.homeservice.address = ""),
            (t.homeserviceTest = ""),
            (t.homeservice.date = "");
          (t.homeservice.time = ""),
            (t.homeservice.homeserviceImage = ""),
            (t.homeservice.otherConcerns = "");
          this.myAppointmentData();
          this.showNotif("top", "Successfully Created");
        })
        .catch(() => {
          this.$q.loading.hide({
            spinner: QSpinnerFacebook,
          });
        });
    },
    uploadInquiryImage(e) {
      let file = e.target.files[0];
      let reader = new FileReader();
      reader.onloadend = function (file) {
        this.inquiryImage = reader.result;
        console.log(this.inquiryImage);
      };
      reader.readAsDataURL(file);
    },
    inquiryAppointment() {
      let t = this;
      const bearerToken = localStorage.getItem("Bearer");

      this.$q.loading.show({
        spinner: QSpinnerFacebook,
      });

      let data = new FormData();

      data.append("user_id", t.myProfile.id);
      data.append("image", t.inquiryImage[0]);
      data.append("otherconcerns", t.inquiry.otherConcerns);
      data.append("type", t.inquiry.type);

      axios
        .post("http://127.0.0.1:8000/api/make-appointment", data, {
          headers: {
            Authorization: `Bearer ${bearerToken}`,
            "Content-Type": "multipart/form-data",
          },
        })
        .then(() => {
          this.$q.loading.hide({
            spinner: QSpinnerFacebook,
          });

          (t.inquiry.inquiryImage = ""), (t.inquiry.otherConcerns = "");
          this.myAppointmentData();

          this.showNotif("top", "Successfully Created");
        })
        .catch(() => {
          this.$q.loading.hide({
            spinner: QSpinnerFacebook,
          });
        });
    },
    myProfileData() {
      try {
        const bearerToken = localStorage.getItem("Bearer");
        console.log("Profile");
        this.$axios
          .get("http://127.0.0.1:8000/api/myProfile", {
            headers: {
              Authorization: `Bearer ${bearerToken}`,
            },
          })
          .then((response) => {
            this.myProfile = response.data;

            console.log("Patient", this.myProfile);
          });
      } catch (error) {
        console.log(error);
      }
    },
    myAppointmentData() {
      try {
        const bearerToken = localStorage.getItem("Bearer");

        this.$axios
          .get("http://127.0.0.1:8000/api/all-appointments", {
            headers: {
              Authorization: `Bearer ${bearerToken}`,
            },
          })
          .then((response) => {
            this.myAppointments = response.data;

            console.log("Appointment", this.myAppointments);
          });
      } catch (error) {
        console.log(error);
      }
    },
  },
  created() {
    this.myProfileData();
    this.myAppointmentData();
  },
  computed: {
    layout() {
      return this.$q.screen.lt.sm
        ? "dense"
        : this.$q.screen.lt.md
        ? "comfortable"
        : "loose";
    },
    changingDateFormat() {
      return moment(this.myAppointments.created_at).format("MM-DD-YYYY");
    },
  },
};
</script>

<style>
</style>