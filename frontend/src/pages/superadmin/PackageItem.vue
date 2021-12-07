<template>
  <div>
    <div>
      <div class="q-pa-md col-xs-12 col-sm-12 col-md-12">
        <q-table
          flat
          bordered
          :data="allPackageItems"
          :columns="columns"
          :filter="filter"
          title="Package Item"
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
              outline
              color="white"
              text-color="black"
              label="Add Package Item"
              @click="openCreatePackageItem"
            />
          </template>

          <template v-slot:body="props">
            <q-tr :props="props">
              <q-td
                v-for="col in props.cols.filter(
                  (col) => col.name !== 'Actions'
                )"
                :key="col.name"
              >
                {{ col.value }}
              </q-td>
              <td key="Actions">
                <q-btn dense flat color="primary" field="edit" icon="edit" />
                <q-btn
                  dense
                  flat
                  color="negative"
                  field="delete"
                  icon="delete"
                />
              </td>
            </q-tr>
          </template>
        </q-table>
        <q-dialog v-model="createPackageItemModal">
          <q-card style="width: 600px; max-width: 80vw">
            <q-card-section>
              <div class="text-h6">PACKAGE ITEMS</div>
            </q-card-section>
            <div class="q-pa-md">
              <q-form @submit="createPackageItem" class="q-gutter-md">
                <q-select
                  multiple
                  outlined
                  label="Items"
                  v-model="packageItem"
                  :options="createOptions"
                />

                <q-input
                  v-model="price"
                  outlined
                  label="Price"
                  lazy-rules
                  :rules="[(val) => (val && val.length > 0) || 'Input price']"
                />

                <div class="text-right">
                  <q-btn
                    label="Cancel"
                    color="primary"
                    flat
                    class="q-ml-sm"
                    @click="closeCreatePackageItem"
                  />
                  <q-btn label="Submit" type="submit" color="primary" />
                </div>
              </q-form>
            </div>
          </q-card>
        </q-dialog>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      allPackageItems: [],
      filter: "",
      createPackageItemModal: true,
      packageItem: null,
      price: "1",
      createOptions: [],
      myProfile: {},
      createOptionsID: [],
      columns: [
        {
          name: "name",
          required: true,
          label: "Items",
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
      ],
    };
  },
  methods: {
    openCreatePackageItem() {
      this.createPackageItemModal = true;
    },
    closeCreatePackageItem() {
      this.createPackageItemModal = false;
    },
    allPackageItemsData() {
      const bearerToken = localStorage.getItem("Bearer");

      this.$axios
        .get("http://localhost:8000/api/allPackageItems", {
          headers: {
            Authorization: `Bearer ${bearerToken}`,
          },
        })
        .then((response) => {
          this.allPackageItems = response.data;
          this.createOptions = response.data.map(
            (packageitem) =>
              // "(Item) " +
              packageitem.name
            // + "     &     " +
            // "(Item ID) " +
            // packageitem.id
          );
        });
    },
    createPackageItem() {
      let t = this;

      console.log(t.packageItem);

      // console.log(data);

      // const bearerToken = localStorage.getItem("Bearer");

      // axios
      //   .post(
      //     "http://localhost:8000/api/createPackageItem",
      //     {
      //       user_id: t.myProfile.id,
      //       item_id: t.packageItem,
      //       price: t.price,
      //     },
      //     {
      //       headers: {
      //         Authorization: `Bearer ${bearerToken}`,
      //       },
      //     }
      //   )
      //   .then((res) => {
      //     this.allPackageItemsData();
      //     // this.$q.loading.hide({
      //     //   spinner: QSpinnerFacebook,
      //     // });
      //     console.log(res);
      //     this.createPackageItemModal = false;
      //     this.showNotif("top", "Successfully Created");
      //   })
      //   .catch((err) => {
      //     console.log(err);
      //   });
    },
    myProfileData() {
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
            this.myProfile = response.data;
          });
      } catch (error) {
        console.log(error);
      }
    },
  },
  created() {
    this.allPackageItemsData();
    this.myProfileData();
  },
};
</script>