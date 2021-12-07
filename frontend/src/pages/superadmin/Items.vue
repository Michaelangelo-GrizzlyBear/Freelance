<template>
  <div>
    <div>
      <div class="q-pa-md col-xs-12 col-sm-12 col-md-12">
        <!-- @@@@@@@@@@@@@@@@@@@ -->
        <q-table
          flat
          bordered
          title="Item"
          :data="allCreatedItems"
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
              label="Add Items"
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
                  @click="
                    editItems(props.row, allCreatedItems.indexOf(props.row))
                  "
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
      <q-dialog v-model="createItemModal">
        <q-card style="width: 600px; max-width: 80vw">
          <q-card-section>
            <div class="text-h6">ITEMS</div>
          </q-card-section>
          <div class="q-pa-md">
            <q-form @submit="createItems" class="q-gutter-md">
              <q-input
                outlined
                label="Item name"
                v-model="items.name"
                lazy-rules
                :rules="[(val) => (val && val.length > 0) || 'Input item name']"
              />
              <q-input
                outlined
                label="Price"
                v-model="items.price"
                lazy-rules
                :rules="[(val) => (val && val.length > 0) || 'Input price']"
              />
              <q-input
                outlined
                v-model="items.description"
                label="Description"
                lazy-rules
                :rules="[
                  (val) => (val && val.length > 0) || 'Input Description',
                ]"
              />

              <q-select
                outlined
                v-model="items.status"
                :options="status"
                label="Status"
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
        v-model="editItemForm"
        transition-show="slide-up"
        transition-hide="slide-down"
      >
        <q-card style="width: 700px; max-width: 80vw">
          <q-card-section>
            <div class="text-h6">Edit Items</div>
          </q-card-section>
          <div class="q-pa-md">
            <q-input
              class="q-my-sm"
              outlined
              label="Item name"
              v-model="edit.name"
              lazy-rules
              :rules="[(val) => (val && val.length > 0) || 'Input item name']"
            />
            <q-input
              class="q-my-sm"
              outlined
              label="Price"
              v-model="edit.price"
            />
            <q-input
              class="q-my-sm"
              outlined
              v-model="edit.itemdescription"
              label="Description"
            />

            <q-select
              class="q-my-sm"
              outlined
              v-model="edit.activeInactive"
              :options="status"
              label="Status"
            />

            <div class="q-ma-md float-right">
              <q-btn label="Cancel" @click="closeEditModal" />
              <q-btn
                class="q-ml-md"
                color="secondary"
                @click="updateItems"
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
      allCreatedItems: [],
      myProfile: {},
      createItemModal: false,
      filter: "",
      mode: "list",
      searchingItems: "",
      initialPagination: {
        sortBy: "desc",
        descending: false,
        page: 1,
        rowsPerPage: 15,
      },
      items: {
        name: "",
        price: "",
        description: "",
        status: "",
      },

      edit: {
        id: "",
        name: "",
        price: "",
        itemdescription: "",
        activeInactive: "",
      },
      editItemForm: false,
      editIndex: -1,
      editId: "",
      editMode: false,
      isEditing: false,

      status: ["Active", "Inactive"],
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
          required: true,
          label: "ID",
          align: "left",
          field: (row) => row.name,
          format: (val) => `${val}`,
          sortable: true,
        },
        {
          name: "price",
          align: "center",
          label: "Price",
          field: "price",
          sortable: true,
        },
        {
          name: "itemdescription",
          label: "Description",
          field: "itemdescription",
          sortable: true,
        },
        {
          name: "activeInactive",
          label: "Status",
          field: "activeInactive",
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
    openCreateModal() {
      this.createItemModal = true;
    },
    closeEditModal() {
      this.editItemForm = false;
    },
    closingModal() {
      this.createItemModal = false;
    },
    createItems(data) {
      this.createItemModal = true;

      let t = this;

      const bearerToken = localStorage.getItem("Bearer");

      console.log("Axiosing", axios);

      this.$q.loading.show({
        spinner: QSpinnerFacebook,
      });
      axios
        .post(
          "http://127.0.0.1:8000/api/addItems",
          {
            user_id: t.myProfile.id,
            name: t.items.name,
            price: t.items.price,
            itemdescription: t.items.description,
            activeInactive: t.items.status,
          },
          {
            headers: {
              Authorization: `Bearer ${bearerToken}`,
            },
          }
        )
        .then(() => {
          this.allItemsData();
          this.$q.loading.hide({
            spinner: QSpinnerFacebook,
          });
          this.createItemModal = false;
          this.showNotif("top", "Successfully Created");
        })
        .catch((err) => {
          console.log(err);
        });
    },
    editItems(items, index) {
      let obj = {
        id: items.id,
        name: items.name,
        price: items.price,
        itemdescription: items.itemdescription,
        activeInactive: items.activeInactive,
      };
      console.log(obj);
      this.editMode = true;
      this.editItemForm = true;
      this.editId = items.id;
      this.edit = obj;
      this.editIndex = index;
    },

    updateItems() {
      let t = this;

      const bearerToken = localStorage.getItem("Bearer");

      if (
        this.edit.name.trim() == "" ||
        this.edit.name.trim() == "" ||
        this.edit.itemdescription.trim() == "" ||
        this.edit.activeInactive.trim() == ""
      ) {
        (this.editItemForm = false),
          this.$q
            .dialog({
              title: "Incomplete Details",
              message: "Please fill up all the fields",
              persistent: true,
              color: "negative",
            })
            .onOk(() => {
              this.editItemForm = true;
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
            (this.editItemForm = true),
              this.$axios
                .put(
                  "http://localhost:8000/api/updateItem/" + t.edit.id,
                  {
                    id: t.edit.id,
                    name: t.edit.name,
                    price: t.edit.price,
                    itemdescription: t.edit.itemdescription,
                    activeInactive: t.edit.activeInactive,
                  },
                  {
                    headers: {
                      Authorization: `Bearer ${bearerToken}`,
                    },
                  }
                )
                .then(() => {
                  // this.edit = res.data;
                  this.allItemsData();
                  this.isEditing = false;

                  this.$q.notify({
                    icon: "info",
                    message: "Item Updated Successfully",
                    color: "positive",
                    position: "top",
                  });

                  this.editItemForm = false;
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
          title: `Delete item?`,
          persistent: true,
          cancel: true,
          color: "negative",
        })
        .onOk(() => {
          this.$q.loading.show({
            spinner: QSpinnerFacebook,
          });
          this.$axios
            .delete(`http://localhost:8000/api/removeItems/${props.id}`, {
              headers: {
                Authorization: `Bearer ${bearerToken}`,
              },
            })
            .then(() => {
              let i = this.allCreatedItems
                .map((data) => data.id)
                .indexOf(props.id);
              this.allCreatedItems.splice(i, 1);
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
                message: err + " " + "Deleting an Item Failed",
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
    allItemsData() {
      this.loading = true;
      const bearerToken = localStorage.getItem("Bearer");

      this.$axios
        .get("http://127.0.0.1:8000/api/allItems", {
          headers: {
            Authorization: `Bearer ${bearerToken}`,
          },
        })
        .then((response) => {
          console.log("All Items", response.data);
          this.allCreatedItems = response.data;
          this.loading = false;
        });
    },
  },
  created() {
    this.myProfileData();
    this.allItemsData();
  },
  computed: {},
  mounted() {},
};
</script>

<style>
</style>