A<template>
  <div>
    <div>
      <div class="q-pa-md col-xs-12 col-sm-12 col-md-12">
        <!-- @@@@@@@@@@@@@@@@@@@ -->
        <div class="q-pa-md col-xs-12 col-sm-12 col-md-12">
          <q-markup-table :separator="separator" flat bordered>
            <template>
              <thead color="secondary">
                <tr>
                  <th class="text-left">Name</th>
                  <th class="text-left">Branch</th>
                  <th class="text-left">Test</th>
                  <th class="text-left">Date</th>
                  <th class="text-left">Time</th>
                  <th class="text-left">Status</th>
                  <th class="text-left">Address</th>
                  <th class="text-left">Type</th>
                  <th class="text-left">Other Concerns</th>
                  <th class="text-left">Remarks</th>
                  <th class="text-left">Image</th>
                  <th class="text-left">Actions</th>
                  <th class="text-left"></th>
                </tr>
              </thead>
            </template>
            <template>
              <!-- <div v-if="loading">
                <q-spinner-oval
                  color="teal"
                  :thickness="5"
                  class="fixed-center"
                  size="3em"
                />
              </div> 
              <tbody v-else> -->
              <tbody>
                <tr v-for="(data, id) in allAppointments" :key="id">
                  <td class="text-left">{{ data.name }}</td>
                  <td class="text-left">{{ data.branch }}</td>
                  <td class="text-left">
                    {{ data.test }}
                  </td>
                  <td class="text-left">{{ data.date }}</td>
                  <td class="text-left">{{ data.time }}</td>
                  <td class="text-left">{{ data.status }}</td>
                  <td class="text-left">{{ data.addressofHomeService }}</td>
                  <td class="text-left">{{ data.type }}</td>
                  <td class="text-left">{{ data.otherconcerns }}</td>
                  <td class="text-left">{{ data.remarks }}</td>

                  <!-- <td class="text-left">
                    <q-btn
                      flat
                      color="secondary"
                      icon-right="mdi-arrow-right"
                      label="For Approval"
                    />
                  </td>
                </tr> -->
                </tr>
              </tbody>
            </template>
          </q-markup-table>
        </div>

        <!-- <q-table
          flat
          bordered
          title="Schedule"
          :data="allAppointments"
          :columns="columns"
          :filter="filter"
          :pagination.sync="initialPagination"
          row-key="id"
        >
          <template v-slot:top-right>
            <q-input
              outlined
              dens
              debounce="300"
              placeholder="Search"
              v-model="filter"
            >
              <template v-slot:append>
                <q-icon name="search" />
              </template>
            </q-input>
          </template>

          <template v-slot:body="props">
            <q-tr :props="props">
              <q-td
                v-for="col in props.cols.filter(
                  (col) => col.name !== 'actions'
                )"
                :key="col.name"
              >
                {{ col.value }}
              </q-td>
              <td key="actions">
                <q-btn dense flat color="primary" field="edit" icon="edit" />
                <q-btn
                  dense
                  flat
                  color="negative"
                  field="delete"
                  icon="delete"
                />
              </td>
               https://stackoverflow.com/questions/56569707/how-do-i-identify-the-cell-selected-in-a-quasar-table -->
        <!-- </q-tr>
          </template>
        </q-table> -->
        <!-- @@@@@@@@@@@@@ -->
      </div>

      <!-- <q-dialog
        v-model="editDoctorForm"
        transition-show="slide-up"
        transition-hide="slide-down"
      >
        <q-card style="width: 700px; max-width: 80vw">
          <q-card-section>
            <div class="text-h6">Edit Doctor</div>
          </q-card-section>
          <div class="q-pa-md">
            <q-input
              outlined
              label="Doctors name"
              v-model="edit.doctorname"
              lazy-rules
              :rules="[(val) => (val && val.length > 0) || 'Input Doctor name']"
            />
            <q-input
              outlined
              label="Specialization"
              v-model="edit.specialization"
              lazy-rules
              :rules="[(val) => (val && val.length > 0) || 'Input price']"
            />
            <q-input
              outlined
              v-model="edit.location"
              label="Location"
              lazy-rules
              :rules="[(val) => (val && val.length > 0) || 'Input Description']"
            />

            <q-input
              outlined
              v-model="edit.schedule"
              label="Doctor's Schedule"
              lazy-rules
              :rules="[
                (val) => (val && val.length > 0) || `Input Doctor's Schedule`,
              ]"
            />
            <q-select
              outlined
              v-model="edit.status"
              :options="status"
              label="Status"
              lazy-rules
              :rules="[(val) => (val && val.length > 0) || 'Input Status']"
            />
            <q-select
              outlined
              v-model="edit.branch"
              :options="branches"
              label="Branches"
              lazy-rules
              :rules="[(val) => (val && val.length > 0) || 'Input Branches']"
            />
            <div class="q-ma-md float-right">
              <q-btn label="Cancel" @click="closeEditModal" />
              <q-btn
                class="q-ml-md"
                color="secondary"
                @click="updateDoctors"
                :disabled="isEditing"
                :loading="isEditing"
                >{{ isEditing ? "Editing..." : "Edit" }}</q-btn
              >
            </div>
          </div>
        </q-card>
      </q-dialog> -->
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { QSpinnerFacebook } from "quasar";

export default {
  data() {
    return {
      publicPath: process.env.BASE_URL,
      separator: "cell",
      loading: true,
      notifications: false,
      allAppointments: [],
      myProfile: {},
      createDoctorModal: false,
      filter: "",
      mode: "list",
      searchingDoctors: "",
      initialPagination: {
        sortBy: "desc",
        descending: false,
        page: 1,
        rowsPerPage: 15,
      },

      edit: {
        name: "",
        branch: "",
        test: "",
        date: "",
        time: "",
        status: "",
        addressofHomeService: "",
        type: "",
        otherConcerns: "",
        remarks: "",
        image: "",
      },
      editScheduleForm: false,
      editIndex: -1,
      editId: "",
      editMode: false,
      isEditing: false,

      status: ["Completed", "Approved", "Pending"],
      branches: ["Quezon City"],
      pagination: {
        page: 1,
      },
      alerts: [
        {
          color: "positive",
          icon: "check_circle_outline",
        },
      ],
      spinnerForDelete: false,
      columns: [
        {
          name: "name",
          align: "center",
          label: "Patient",
          field: "name",
          sortable: true,
        },
        {
          name: "branch",
          label: "Branch",
          field: "branch",
          sortable: true,
        },
        {
          name: "test",
          label: "Tests",
          field: "test",
        },
        {
          name: "time",
          label: "Time",
          field: "time",
        },
        {
          name: "status",
          label: "Status",
          field: "status",
        },
        {
          name: "addressofHomeService",
          label: "Address",
          field: "addressofHomeService",
        },
        {
          name: "type",
          label: "Type",
          field: "type",
        },
        {
          name: "otherconcerns",
          label: "Otherconcerns",
          field: "otherconcerns",
        },
        {
          name: "remarks",
          label: "Remarks",
          field: "remarks",
        },
        {
          name: "image",
          label: "Image",
          field: "image",
        },
        {
          name: "actions",
          label: "Actions",
          field: "actions",
        },
      ],
    };
  },
  methods: {
    // closeEditModal() {
    //   this.editDoctorForm = false;
    // },
    // editDoctors(doctors, index) {
    //   let obj = {
    //     id: doctors.id,
    //     doctorname: doctors.doctorname,
    //     specialization: doctors.specialization,
    //     location: doctors.location,
    //     branch: doctors.branch,
    //     schedule: doctors.schedule,
    //     status: doctors.status,
    //   };
    //   console.log(obj);
    //   this.editMode = true;
    //   this.editDoctorForm = true;
    //   this.editId = doctors.id;
    //   this.edit = obj;
    //   this.editIndex = index;
    // },

    // updateDoctors() {
    //   let t = this;

    //   const bearerToken = localStorage.getItem("Bearer");

    //   if (
    //     this.edit.doctorname.trim() == "" ||
    //     this.edit.specialization.trim() == "" ||
    //     this.edit.location.trim() == "" ||
    //     this.edit.branch.trim() == "" ||
    //     this.edit.schedule.trim() == "" ||
    //     this.edit.status.trim() == ""
    //   ) {
    //     (this.editDoctorForm = false),
    //       this.$q
    //         .dialog({
    //           title: "Incomplete Details",
    //           message: "Please fill up all the fields",
    //           persistent: true,
    //           color: "negative",
    //         })
    //         .onOk(() => {
    //           this.editDoctorForm = true;
    //         });
    //   } else {
    //     this.isEditing = true;
    //     this.$q
    //       .dialog({
    //         title: `Confirm Update?`,
    //         persistent: true,
    //         cancel: true,
    //       })
    //       .onOk(() => {
    //         (this.editDoctorForm = true),
    //           this.$axios
    //             .put(
    //               "http://localhost:8000/api/update-doctor/" + t.edit.id,
    //               {
    //                 doctorname: t.edit.doctorname,
    //                 specialization: t.edit.specialization,
    //                 location: t.edit.location,
    //                 schedule: t.edit.schedule,
    //                 branch: t.edit.branch,
    //                 status: t.edit.status,
    //               },
    //               {
    //                 headers: {
    //                   Authorization: `Bearer ${bearerToken}`,
    //                 },
    //               }
    //             )
    //             .then(() => {
    //               // this.edit = res.data;

    //               this.isEditing = false;

    //               this.$q.notify({
    //                 icon: "info",
    //                 message: "Item Updated Successfully",
    //                 color: "positive",
    //                 position: "top",
    //               });

    //               this.editDoctorForm = false;
    //             })
    //             .catch((err) => {
    //               this.$q.notify({
    //                 icon: "error",
    //                 message: err + " " + "Items Update Failed",
    //                 color: "negative",
    //               });
    //             });
    //       });
    //   }
    // },
    // deleteItem(props) {
    //   // console.log(props.id);

    //   const bearerToken = localStorage.getItem("Bearer");

    //   this.$q
    //     .dialog({
    //       title: `Delete Doctor?`,
    //       persistent: true,
    //       cancel: true,
    //       color: "negative",
    //     })
    //     .onOk(() => {
    //       this.$q.loading.show({
    //         spinner: QSpinnerFacebook,
    //       });
    //       this.$axios
    //         .delete(`http://localhost:8000/api/remove-doctor/${props.id}`, {
    //           headers: {
    //             Authorization: `Bearer ${bearerToken}`,
    //           },
    //         })
    //         .then(() => {
    //           let i = this.allDoctors.map((data) => data.id).indexOf(props.id);
    //           this.allDoctors.splice(i, 1);
    //           this.$q.loading.hide({
    //             spinner: QSpinnerFacebook,
    //           });
    //           this.$q.notify({
    //             icon: "check_circle",
    //             message: "Successfully Deleted",
    //             color: "positive",
    //             position: "top",
    //           });
    //         })
    //         .catch((err) => {
    //           this.$q.notify({
    //             icon: "error",
    //             message: err + " " + "Deleting doctor Failed",
    //             color: "negative",
    //           });
    //         });
    //     });
    // },

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

            console.log("Super Admin", this.myProfile);
          });
      } catch (error) {
        console.log(error);
      }
    },
    allAppointmentsData() {
      try {
        const bearerToken = localStorage.getItem("Bearer");
        console.log("Profile");
        this.$axios
          .get("http://127.0.0.1:8000/api/all-appointments", {
            headers: {
              Authorization: `Bearer ${bearerToken}`,
            },
          })
          .then((response) => {
            this.allAppointments = response.data;

            // console.log("Super Admin", this.myProfile);
          });
      } catch (error) {
        console.log(error);
      }
    },
  },
  created() {
    this.myProfileData();
    this.allAppointmentsData();
  },

  computed: {},
  mounted() {},
};
</script>

<style>
</style>