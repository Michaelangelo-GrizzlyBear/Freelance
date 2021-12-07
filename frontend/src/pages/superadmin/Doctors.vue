A<template>
  <div>
    <div>
      <div class="q-pa-md col-xs-12 col-sm-12 col-md-12">
        <!-- @@@@@@@@@@@@@@@@@@@ -->
        <q-table
          flat
          bordered
          title="Doctor"
          :data="allDoctors"
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

            <div class="q-pa-sm q-gutter-sm"></div>
            <q-btn
              @click="openCreateModal"
              outline
              color="white"
              text-color="black"
              label="Add Doctor"
            />
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
                <q-btn
                  dense
                  flat
                  color="primary"
                  field="edit"
                  icon="edit"
                  @click="editDoctors(props.row, allDoctors.indexOf(props.row))"
                />
                <q-btn
                  dense
                  flat
                  color="negative"
                  field="delete"
                  icon="delete"
                  @click="deleteItem(props.row)"
                />
              </td>
              <!-- https://stackoverflow.com/questions/56569707/how-do-i-identify-the-cell-selected-in-a-quasar-table -->
            </q-tr>
          </template>
        </q-table>
        <!-- @@@@@@@@@@@@@ -->
      </div>
      <q-dialog v-model="createDoctorModal">
        <q-card style="width: 600px; max-width: 80vw">
          <q-card-section>
            <div class="text-h6">Doctors</div>
          </q-card-section>
          <div class="q-pa-md">
            <q-form @submit="createDoctor" class="q-gutter-md">
              <q-input
                outlined
                label="Doctors name"
                v-model="doctors.doctorname"
                lazy-rules
                :rules="[
                  (val) => (val && val.length > 0) || 'Input Doctor name',
                ]"
              />
              <q-input
                outlined
                label="Specialization"
                v-model="doctors.specialization"
                lazy-rules
                :rules="[(val) => (val && val.length > 0) || 'Input price']"
              />
              <q-input
                outlined
                v-model="doctors.location"
                label="Location"
                lazy-rules
                :rules="[
                  (val) => (val && val.length > 0) || 'Input Description',
                ]"
              />

              <q-input
                outlined
                v-model="doctors.schedule"
                label="Doctor's Schedule"
                lazy-rules
                :rules="[
                  (val) => (val && val.length > 0) || `Input Doctor's Schedule`,
                ]"
              />
              <q-select
                outlined
                v-model="doctors.status"
                :options="status"
                label="Status"
                lazy-rules
                :rules="[(val) => (val && val.length > 0) || 'Input Status']"
              />
              <q-select
                outlined
                v-model="doctors.branch"
                :options="branches"
                label="Branches"
                lazy-rules
                :rules="[(val) => (val && val.length > 0) || 'Input Branches']"
              />

              <div class="text-right">
                <q-btn
                  label="Cancel"
                  color="primary"
                  flat
                  class="q-ml-sm"
                  @click="closingModal()"
                />
                <q-btn label="Submit" type="submit" color="primary" />
              </div>
            </q-form>
          </div>
        </q-card>
      </q-dialog>

      <q-dialog
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
      </q-dialog>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { QSpinnerFacebook } from "quasar";

export default {
  data() {
    return {
      loading: true,
      notifications: false,
      allDoctors: [],
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
      doctors: {
        doctorname: "",
        specialization: "",
        location: "",
        branch: "",
        schedule: "",
        status: "",
      },

      edit: {
        doctorname: "",
        specialization: "",
        location: "",
        branch: "",
        schedule: "",
        status: "",
      },
      editDoctorForm: false,
      editIndex: -1,
      editId: "",
      editMode: false,
      isEditing: false,

      status: ["Active", "Inactive"],
      branches: ["Quezon City "],
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
        // {
        //   name: "id",
        //   required: true,
        //   label: "ID",
        //   align: "left",
        //   field: (row) => row.name,
        //   format: (val) => `${val}`,
        //   sortable: true,
        // },
        {
          name: "doctorname",
          align: "center",
          label: "Doctor name",
          field: "doctorname",
          sortable: true,
        },
        {
          name: "specialization",
          label: "Specialization",
          field: "specialization",
          sortable: true,
        },
        {
          name: "branch",
          label: "Branch",
          field: "branch",
        },
        {
          name: "schedule",
          label: "Schedule",
          field: "schedule",
        },
        {
          name: "actions",
          align: "center",
          label: "Actions",
          field: "actions",
        },
      ],
    };
  },
  methods: {
    openCreateModal() {
      this.createDoctorModal = true;
    },
    closeEditModal() {
      this.editDoctorForm = false;
    },
    closingModal() {
      this.createDoctorModal = false;
    },
    createDoctor() {
      this.createDoctorModal = true;

      let t = this;

      const bearerToken = localStorage.getItem("Bearer");

      console.log("Axios", t.myProfile.id);

      this.$q.loading.show({
        spinner: QSpinnerFacebook,
      });
      axios
        .post(
          "http://localhost:8000/api/add-doctor",
          {
            user_id: t.myProfile.id,
            doctorname: t.doctors.doctorname,
            specialization: t.doctors.specialization,
            location: t.doctors.location,
            branch: t.doctors.branch,
            schedule: t.doctors.schedule,
            status: t.doctors.status,
          },
          {
            headers: {
              Authorization: `Bearer ${bearerToken}`,
            },
          }
        )
        .then(() => {
          this.allDoctorsData();
          this.$q.loading.hide({
            spinner: QSpinnerFacebook,
          });
          this.createDoctorModal = false;
          this.showNotif("top", "Successfully Created");
        })
        .catch((err) => {
          this.createDoctorModal = false;
          console.log(err);
        });
    },
    editDoctors(doctors, index) {
      let obj = {
        id: doctors.id,
        doctorname: doctors.doctorname,
        specialization: doctors.specialization,
        location: doctors.location,
        branch: doctors.branch,
        schedule: doctors.schedule,
        status: doctors.status,
      };
      console.log(obj);
      this.editMode = true;
      this.editDoctorForm = true;
      this.editId = doctors.id;
      this.edit = obj;
      this.editIndex = index;
    },

    updateDoctors() {
      let t = this;

      const bearerToken = localStorage.getItem("Bearer");

      if (
        this.edit.doctorname.trim() == "" ||
        this.edit.specialization.trim() == "" ||
        this.edit.location.trim() == "" ||
        this.edit.branch.trim() == "" ||
        this.edit.schedule.trim() == "" ||
        this.edit.status.trim() == ""
      ) {
        (this.editDoctorForm = false),
          this.$q
            .dialog({
              title: "Incomplete Details",
              message: "Please fill up all the fields",
              persistent: true,
              color: "negative",
            })
            .onOk(() => {
              this.editDoctorForm = true;
            });
      } else {
        this.isEditing = true;
        this.$q
          .dialog({
            title: `Confirm Update?`,
            persistent: true,
            cancel: true,
          })
          .onOk(() => {
            (this.editDoctorForm = true),
              this.$axios
                .put(
                  "http://localhost:8000/api/update-doctor/" + t.edit.id,
                  {
                    doctorname: t.edit.doctorname,
                    specialization: t.edit.specialization,
                    location: t.edit.location,
                    schedule: t.edit.schedule,
                    branch: t.edit.branch,
                    status: t.edit.status,
                  },
                  {
                    headers: {
                      Authorization: `Bearer ${bearerToken}`,
                    },
                  }
                )
                .then(() => {
                  // this.edit = res.data;
                  this.allDoctorsData();
                  this.isEditing = false;

                  this.$q.notify({
                    icon: "info",
                    message: "Item Updated Successfully",
                    color: "positive",
                    position: "top",
                  });

                  this.editDoctorForm = false;
                })
                .catch((err) => {
                  this.$q.notify({
                    icon: "error",
                    message: err + " " + "Items Update Failed",
                    color: "negative",
                  });
                });
          });
      }
    },
    deleteItem(props) {
      // console.log(props.id);

      const bearerToken = localStorage.getItem("Bearer");

      this.$q
        .dialog({
          title: `Delete Doctor?`,
          persistent: true,
          cancel: true,
          color: "negative",
        })
        .onOk(() => {
          this.$q.loading.show({
            spinner: QSpinnerFacebook,
          });
          this.$axios
            .delete(`http://localhost:8000/api/remove-doctor/${props.id}`, {
              headers: {
                Authorization: `Bearer ${bearerToken}`,
              },
            })
            .then(() => {
              let i = this.allDoctors.map((data) => data.id).indexOf(props.id);
              this.allDoctors.splice(i, 1);
              this.$q.loading.hide({
                spinner: QSpinnerFacebook,
              });
              this.$q.notify({
                icon: "check_circle",
                message: "Successfully Deleted",
                color: "positive",
                position: "top",
              });
            })
            .catch((err) => {
              this.$q.notify({
                icon: "error",
                message: err + " " + "Deleting doctor Failed",
                color: "negative",
              });
            });
        });
    },

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
    allDoctorsData() {
      this.loading = true;
      const bearerToken = localStorage.getItem("Bearer");

      this.$axios
        .get("http://localhost:8000/api/all-doctors", {
          headers: {
            Authorization: `Bearer ${bearerToken}`,
          },
        })
        .then((response) => {
          console.log("All Items", response.data);
          this.allDoctors = response.data;
          this.loading = false;
        });
    },
  },
  created() {
    this.myProfileData();
    this.allDoctorsData();
  },
  computed: {},
  mounted() {},
};
</script>

<style>
</style>