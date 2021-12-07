<template>
  <div>
    <q-page>
      <div class="q-pa-sm" style="max-width: 500px">
        <div class="column">
          <div class="col-12">
            <q-input
              outlined
              type="search"
              placeholder="Search a Laboratory test"
            >
              <template v-slot:append>
                <q-icon name="search" />
              </template>
            </q-input>
          </div>
          <q-separator />
          <div class="col">
            <div class="q-mx-sm q-mt-md" style="max-width: 350px">
              <q-list bordered>
                <q-expansion-item
                  group="somegroup"
                  label="Comprehensive Laboratory Packages"
                  header-class="text-primary"
                >
                  <q-card>
                    <div class="q-pa-md">
                      <ul>
                        <li>Complete Blood Count</li>
                        <li>Inorganic Phosphorus</li>
                        <li>Urinalysis</li>
                        <li>Sodium</li>
                        <li>Fecalysis</li>
                        <li>Potassium</li>
                        <li>Fasting Blood Sugar</li>
                        <li>Chloride</li>
                        <li>BUN</li>
                        <li>Total Calcium</li>
                        <li>Creatinine</li>
                        <li>LDH</li>
                        <li>SGPT</li>
                        <li>SGOT</li>
                        <li>Alkaline</li>
                        <li>Phosphatase</li>
                      </ul>
                    </div>
                    <q-separator />
                    <q-item-section class="q-pa-sm">
                      <q-item-label class="text-center text-negative" lines="3"
                        >PREPARATION:</q-item-label
                      >
                      <q-item-label class="text-center text-negative" caption
                        >10-12 hours fasting; No strenuous exercise; Water is
                        allowed (1-2 Glasses).
                      </q-item-label>
                    </q-item-section>
                  </q-card>
                </q-expansion-item>

                <q-separator />

                <q-expansion-item
                  group="somegroup"
                  label="ELECTROLYTE PACKAGE 1"
                  header-class="text-teal"
                >
                  <q-card>
                    <div class="q-pa-md">
                      <li>Sodium</li>
                      <li>Potassium</li>
                    </div>
                    <q-separator />
                    <q-item-section class="q-pa-sm">
                      <q-item-label class="text-center text-negative" lines="3"
                        >PREPARATION:</q-item-label
                      >
                      <q-item-label class="text-center text-negative" caption
                        >No strenuous exercise
                      </q-item-label>
                    </q-item-section>
                  </q-card>
                </q-expansion-item>

                <q-separator />

                <q-expansion-item
                  default-opened
                  group="somegroup"
                  label="ELECTROLYTE PACKAGE 2"
                  header-class="text-purple"
                >
                  <q-card>
                    <div class="q-pa-md">
                      <ul>
                        <li>Complete Blood Count</li>
                        <li>Uric Acid</li>
                        <li>Urinalysis</li>
                        <li>SGPT</li>
                        <li>Fasting Blood Sugar</li>
                        <li>
                          Lipid Profile (Cholesterol, Trigycerides,
                          Lipoproteint)
                        </li>
                        <li>Creatinine</li>
                      </ul>
                    </div>
                    <q-separator />
                    <q-item-section class="q-pa-sm">
                      <q-item-label class="text-center text-negative" lines="3"
                        >PREPARATION:</q-item-label
                      >
                      <q-item-label class="text-center text-negative" caption
                        >10-12 hours fasting; No strenuous exercise; Water is
                        allowed (1-2 Glasses).
                      </q-item-label>
                    </q-item-section>
                  </q-card>
                </q-expansion-item>

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