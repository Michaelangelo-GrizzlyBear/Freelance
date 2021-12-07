<template>
  <div>
    <q-page>
      <div>
        <div class="fit row wrap justify-between content-start">
          <q-card-section class="q-pa-lg">
            <!-- <img
              :src="'http://127.0.0.1:8000/' + userProfile.image"
              style="height: 140px; max-width: 150px"
            /> -->
          </q-card-section>
          <q-card-section class="q-pa-lg q-mt-md">
            <q-btn
              @click="dialogAllAddress = true"
              class="q-pa-mx q-mx-sm"
              push
              color="primary"
              round
              icon="house"
              stack
              size="md"
              outline
            />
            <q-btn
              @click="editAlert"
              class="q-pa-mx"
              push
              color="primary"
              outline
              round
              icon="build"
              size="md"
            />
          </q-card-section>
        </div>

        <!-- <div class="q-pa-md">
          <q-card>
            <q-file
              class="col-12 q-pa-sm q-mt-md"
              label="Profile Picture"
              accept=".jpg, .jpeg, .png, image/*"
            >
              <template v-slot:prepend>
                <q-icon name="attach_file" />
              </template> </q-file
          ></q-card>
        </div> -->
        <!-- <div></div> -->
        <div class="q-pa-md q-gutter-md">
          <q-card>
            <q-form _method="PATCH" enctype="multipart/form-data">
              <div class="row">
                <q-input
                  class="q-pa-md col-6"
                  color="primary"
                  label="Lastname"
                  name="lastname"
                  v-model="userProfile.lastname"
                  clearable
                  outlined
                  :disable="disableInput"
                />
                <q-input
                  class="q-pa-md col-6"
                  color="primary"
                  label="Firstname"
                  name="firstname"
                  v-model="userProfile.firstname"
                  clearable
                  outlined
                  :disable="disableInput"
                />
                <q-input
                  class="q-pa-md col-6"
                  color="primary"
                  label="Middlename"
                  name="middlename"
                  v-model="userProfile.middlename"
                  clearable
                  outlined
                  :disable="disableInput"
                />
                <q-input
                  class="q-pa-md col-6"
                  label="Birthday"
                  name="birthDate"
                  v-model="userProfile.birthDate"
                  mask="date"
                  :rules="['date']"
                  outlined
                  :disable="disableInput"
                >
                  <template v-slot:append>
                    <q-icon name="event" class="cursor-pointer">
                      <q-popup-proxy>
                        <q-date v-model="userProfile.birthDate"></q-date>
                      </q-popup-proxy>
                    </q-icon>
                  </template>
                </q-input>
                <q-input
                  class="q-pa-md col-6"
                  color="primary"
                  label="Birthplace"
                  name="birthPlace"
                  v-model="userProfile.birthPlace"
                  clearable
                  outlined
                  :disable="disableInput"
                />
                <q-input
                  class="q-pa-md col-6"
                  color="primary"
                  label="Suffix"
                  name="suffix"
                  v-model="userProfile.suffix"
                  clearable
                  outlined
                  :disable="disableInput"
                />
                <q-input
                  class="q-pa-md col-6"
                  color="primary"
                  label="Age"
                  name="age"
                  v-model="userProfile.age"
                  clearable
                  outlined
                  :disable="disableInput"
                />
                <q-input
                  class="q-pa-md col-6"
                  color="primary"
                  label="Sex"
                  name="sex"
                  v-model="userProfile.sex"
                  clearable
                  outlined
                  :disable="disableInput"
                />
                <q-input
                  class="q-pa-md col-6"
                  color="primary"
                  label="Contact"
                  name="contact"
                  v-model="userProfile.contact"
                  clearable
                  outlined
                  :disable="disableInput"
                />
                <q-input
                  class="q-pa-md col-6"
                  color="primary"
                  label="Emergency No."
                  name="emergencyNo"
                  v-model="userProfile.emergencyNo"
                  type="number"
                  clearable
                  outlined
                  :disable="disableInput"
                />
                <q-input
                  class="q-pa-md col-6"
                  color="primary"
                  label="Emergency Contact"
                  name="emergencyContact"
                  v-model="userProfile.emergencyContact"
                  clearable
                  outlined
                  :disable="disableInput"
                />
                <q-input
                  class="q-pa-md col-6"
                  color="primary"
                  label="Email"
                  name="email"
                  v-model="userProfile.email"
                  clearable
                  outlined
                  :disable="disableInput"
                />
                <q-input
                  class="q-pa-md col-12"
                  color="primary"
                  label="Password"
                  type="password"
                  name="password"
                  v-model="userProfile.password"
                  clearable
                  outlined
                  :disable="disableInput"
                />
              </div>
              <div>
                <q-btn
                  class="full-width"
                  label="Update"
                  type="submit button"
                  color="positive"
                  :disable="disableInput"
                />
              </div>

              <!-- <q-dialog v-model="dialogAddAddress" persistent>
                <q-card style="width: 500px">
                  <q-card-section>
                    <div class="text-h6 text-uppercase">Adding an Address</div>

                    <q-form>
                      <div class="row">
                        <q-input
                          class="col-6 q-pa-sm"
                          outlined
                          label="House number"
                          lazy-rules
                          :rules="[
                            (val) => !!val || 'House number is required',
                          ]"
                          v-model="home.houseNo"
                        />
                        <q-input
                          class="col-6 q-pa-sm"
                          outlined
                          label="Street"
                          lazy-rules
                          :rules="[
                            (val) => !!val || 'House number is required',
                          ]"
                          v-model="home.street"
                        />
                        <q-input
                          class="col-6 q-pa-sm"
                          outlined
                          label="Barangay"
                          lazy-rules
                          :rules="[(val) => !!val || 'Barangay is required']"
                          v-model="home.barangay"
                        />
                        <q-input
                          class="col-6 q-pa-sm"
                          outlined
                          label="Region"
                          lazy-rules
                          :rules="[(val) => !!val || 'Region is required']"
                          v-model="home.region"
                        />
                        <q-input
                          class="col-6 q-pa-sm"
                          outlined
                          label="City"
                          lazy-rules
                          :rules="[(val) => !!val || 'City is required']"
                          v-model="home.city"
                        />
                        <q-input
                          class="col-6 q-pa-sm"
                          outlined
                          label="Zip Code"
                          lazy-rules
                          :rules="[(val) => !!val || 'Region is required']"
                          v-model="home.zipCode"
                        />
                      </div>
                      <div>
                        <q-btn
                          @click="dialogAddAddress = false"
                          class="full-width q-my-sm"
                          label="Cancel "
                          type="submit button"
                          color="negative"
                        />
                        <q-btn
                          class="full-width"
                          label="Add "
                          type="submit button"
                          color="positive"
                        />
                      </div>
                    </q-form>
                  </q-card-section>
                </q-card>
              </q-dialog>  -->
            </q-form></q-card
          >
          <q-dialog v-model="dialogAllAddress" persistent>
            <q-card style="width: 500px">
              <q-card-section>
                <div class="row justify-around">
                  <div class="col-6 text-h6">Address</div>
                  <q-btn @click="dialogAddAddress = true" label="Add Address" />
                </div>
              </q-card-section>

              <q-card-section class="q-pt-none">
                <section class="section">
                  <div class="container">
                    <div class="b-table has-pagination">
                      <div class="table-wrapper has-mobile-cards">
                        <table
                          class="
                            table
                            is-fullwidth is-striped is-hoverable is-fullwidth
                          "
                        >
                          <thead>
                            <tr>
                              <th></th>
                              <th>House number</th>
                              <th>Street</th>
                              <th>Barangay</th>
                              <th>Region</th>
                              <th>City</th>
                              <th>Zipcode</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <!-- <td class="is-image-cell">
                                    <div class="image">
                                      <img
                                        src="https://avatars.dicebear.com/v2/initials/rebecca-bauch.svg"
                                        class="is-rounded"
                                      />
                                    </div>
                                  </td> -->
                              <td data-label="House Number">35</td>
                              <td data-label="Streeet">Hoping</td>
                              <td data-label="Barangay">Healing</td>
                              <td data-label="Region" class="is-progress-cell">
                                <!-- <progress
                                      max="100"
                                      class="progress is-small is-primary"
                                      value="79"
                                    >
                                      79
                                    </progress> -->
                                National Capital Region
                              </td>
                              <td data-label="City">Quezon City</td>
                              <td data-label="Zipcode">1116</td>
                              <td class="is-actions-cell">
                                <div class="buttons is-right">
                                  <q-btn
                                    class="q-ma-xs"
                                    round
                                    color="primary"
                                    icon="visibility"
                                    size="xs"
                                  />

                                  <q-btn
                                    class="q-ma-xs"
                                    round
                                    color="positive"
                                    icon="edit"
                                    size="xs"
                                  />

                                  <q-btn
                                    class="q-ma-xs"
                                    round
                                    color="negative"
                                    icon="delete_outline"
                                    size="xs"
                                  />
                                </div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="notification">
                        <div class="level">
                          <div class="level-left">
                            <div class="level-item">
                              <div class="buttons has-addons">
                                <button type="button" class="button is-active">
                                  1
                                </button>
                                <button type="button" class="button">2</button>
                                <button type="button" class="button">3</button>
                              </div>
                            </div>
                          </div>
                          <div class="level-right">
                            <div class="level-item">
                              <small>Page 1 of 3</small>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </section>
              </q-card-section>

              <q-card-actions align="right" class="bg-white text-teal">
                <q-btn flat label="Close" v-close-popup />
              </q-card-actions>
            </q-card>
          </q-dialog>
        </div>
      </div>
    </q-page>
  </div>
</template>

<script>
import "../../css/profile.scss";

export default {
  data() {
    return {
      props: {
        // userProfile: {
        //   required: true,
        //   type: Array,
        // },
      },
      userProfile: {},
      home: {
        houseNo: "",
        street: "",
        barangay: "",
        region: "",
        city: "",
        zipCode: "",
      },
      dialogAllAddress: false,
      dialogAddAddress: false,
      persistent: false,
      imageUrl: null,
      profilePic: null,
      disableInput: true,
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
      },
      image: null,
      props: {
        image: Array,
      },
    };
  },
  methods: {
    // updateProfile() {
    //   this.$session.start();
    //   const token = this.$session.get("token");

    //   // console.log(token);
    //   // console.log(this.image);

    //   const data = new FormData();
    //   data.append("firstname", this.userData.firstname);
    //   data.append("middlename", this.userData.middlename);
    //   data.append("birthDate", this.userData.birthDate);
    //   data.append("birthPlace", this.userData.birthPlace);
    //   data.append("suffix", this.userData.suffix);
    //   data.append("sex", this.userData.sex);
    //   data.append("age", this.userData.age);
    //   data.append("contact", this.userData.contact);
    //   data.append("emergencyNo", this.userData.emergencyNo);
    //   data.append("emergencyContact", this.userData.emergencyContact);
    //   data.append("email", this.userData.email);
    //   data.append("password", this.userData.password);
    //   data.append("image", this.image.files[0]);

    //   console.log(this.userProfile);

    //   try {
    //     this.$axios
    //       .patch(
    //         "updateProfile/",
    //         {
    //           data,
    //         },
    //         {
    //           headers: {
    //             Authorization: `Bearer ${token}`,
    //             "Content-Type": "application/json",
    //           },
    //         }
    //       )
    //       .then((res) => {
    //         console.log(res, "Successfully Updated");
    //       });
    //   } catch (error) {
    //     console.log(error);
    //   }
    // },
    editAlert() {
      this.$q
        .dialog({
          title: "Do you want to edit your Profile?",
          cancel: true,
          persistent: true,
        })
        .onOk(() => {
          this.disableInput = !this.disableInput;
        })
        .onCancel(() => {
          // console.log('Cancel')
        });
    },
  },
  computed: {},
  created() {},
  mounted() {
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
          // console.log("My Profile", response);
          this.userProfile = response.data;
        });
    } catch (error) {
      console.log(error);
    }
  },
};
</script>