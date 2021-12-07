<template>
  <div>
    <q-page>
      <div class="q-pa-sm" style="max-width: 100%">
        <div class="column">
          <div class="col-12">
            <q-input outlined type="search" placeholder="Search a Doctor">
              <template v-slot:append>
                <q-icon name="search" />
              </template>
            </q-input>
          </div>
          <q-separator />
          <div class="col">
            <div class="col-12">
              <q-list class="q-pa-md" bordered>
                <q-card class="my-card" flat square>
                  <q-card-section horizontal>
                    <q-card-section class="q-pt-xs">
                      <q-item-label class="text-h6 q-pt-sm q-pl-sm"
                        >Dr. ABC</q-item-label
                      >
                      <q-item-label class="q-pl-sm" caption>
                        Cardiologist
                        <q-item-label class="column items-end">
                          <q-btn icon="place" color="primary" outline />
                        </q-item-label>
                      </q-item-label>

                      <q-item-label class="q-pl-sm q-pt-sm" caption>
                        Quezon City
                      </q-item-label>
                      <q-item-label class="q-pl-sm" caption>
                        Branch: Metro Manila
                      </q-item-label>
                      <div
                        class="text-caption text-italic text-grey q-pa-md"
                      ></div>
                      <div class="text-caption text-italic text-grey q-pl-md">
                        Schedule:
                        <div class="text-oveline text-italic text-grey q-pl-md">
                          Monday from 8:00am to 11:00am
                        </div>
                        <div class="text-oveline text-italic text-grey q-pl-md">
                          Tuesday from 6:00am to 9:00am
                        </div>
                        <div class="text-oveline text-italic text-grey q-pl-md">
                          Friday from 9:00am to 12:00am
                        </div>
                      </div>
                    </q-card-section>
                  </q-card-section>
                </q-card>
                <q-separator />
                <q-card class="my-card" flat square>
                  <q-card-section horizontal>
                    <q-card-section class="q-pt-xs">
                      <q-item-label class="text-h6 q-pt-sm q-pl-sm"
                        >Dr. DEF</q-item-label
                      >
                      <q-item-label class="q-pl-sm" caption>
                        Ophthalmologist
                        <q-item-label class="column items-end">
                          <q-btn icon="place" color="primary" outline />
                        </q-item-label>
                      </q-item-label>

                      <q-item-label class="q-pl-sm q-pt-sm" caption>
                        Manila City
                      </q-item-label>
                      <q-item-label class="q-pl-sm" caption>
                        Branch: Metro Manila
                      </q-item-label>
                      <div
                        class="text-caption text-italic text-grey q-pa-md"
                      ></div>
                      <div class="text-caption text-italic text-grey q-pl-md">
                        Schedule:
                        <div class="text-oveline text-italic text-grey q-pl-md">
                          Tuesday from 6:00am to 9:00am
                        </div>
                        <div class="text-oveline text-italic text-grey q-pl-md">
                          Friday from 9:00am to 6:00pm
                        </div>
                      </div>
                    </q-card-section>
                  </q-card-section>
                </q-card>
                <q-separator />
                <q-separator />
                <q-card class="my-card" flat square>
                  <q-card-section horizontal>
                    <q-card-section class="q-pt-xs">
                      <q-item-label class="text-h6 q-pt-sm q-pl-sm"
                        >Dr. GHI</q-item-label
                      >
                      <q-item-label class="q-pl-sm" caption>
                        Intenal Medicine
                        <q-item-label class="column items-end">
                          <q-btn icon="place" color="primary" outline />
                        </q-item-label>
                      </q-item-label>

                      <q-item-label class="q-pl-sm q-pt-sm" caption>
                        Ortigas City
                      </q-item-label>
                      <q-item-label class="q-pl-sm" caption>
                        Branch: Metro Manila
                      </q-item-label>
                      <div
                        class="text-caption text-italic text-grey q-pa-md"
                      ></div>
                      <div class="text-caption text-italic text-grey q-pl-md">
                        Schedule:
                        <div class="text-oveline text-italic text-grey q-pl-md">
                          Thursday from 6:00am to 9:00am
                        </div>
                        <div class="text-oveline text-italic text-grey q-pl-md">
                          Friday from 6:00am to 9:00am
                        </div>
                        <div class="text-oveline text-italic text-grey q-pl-md">
                          Saturday from 9:00am to 6:00pm
                        </div>
                      </div>
                    </q-card-section>
                  </q-card-section>
                </q-card>
                <q-separator />
              </q-list>
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