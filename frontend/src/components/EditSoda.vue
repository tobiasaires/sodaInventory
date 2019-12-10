<template>
    <v-card>
            <v-card-title>
              <span class="headline">Novo</span>
            </v-card-title>
            <v-card-text>
              <v-container>
                <v-form
                  ref="form"
                  v-model="valid"
                  lazy-validation
                >
                    <v-row>
                    <v-col cols="12" sm="6" md="4">
                        <v-text-field
                        v-model="soda.brand"
                        label="Marca"
                        :rules="[rules.required]"
                        maxLength="30"
                        outlined
                        required
                        >
                        </v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                        <v-select
                            :items="itemsType"
                            label="Tipo"
                            v-model="soda.type"
                            outlined
                            :rules="[rules.required]"
                        ></v-select>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                        <v-text-field required v-model="soda.unitPrice" outlined  label="Preço Unitário"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                        <v-text-field outlined :rules="[rules.required]" v-model="soda.measureValue" label="Valor de Medida"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                        <v-select
                            :items="itemsMeasureUnit"
                            label="Unidade de Medida"
                            v-model="soda.measureUnit"
                            outlined
                            :rules="[rules.required]"
                            required
                        ></v-select>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                        <v-text-field  outlined :rules="[rules.required]" v-model="soda.quantity" type="number" label="Quantidade"></v-text-field>
                    </v-col>
                    </v-row>
                </v-form>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn :disabled="!valid" color="blue darken-1" text @click="updateSoda">Salvar</v-btn>
            </v-card-actions>
          </v-card>
</template>


<script>
  import {VMoney} from 'v-money'
  import axios from 'axios'


  export default {
    data: () => ({
      dialog: false,
      valid: true,
      timeout: 2000,
      itemsType: ['Pet', 'Garrafa', 'Lata'],
      itemsMeasureUnit: ['mL', 'L'],
      loading: true,
      money: {
        decimal: ',',
        thousands: '.',
        prefix: 'R$ ',
        precision: 2,
        masked: false
      },
      rules: {
          required: value => !!value || 'Required.',
        },
      soda: {},
    }),



    created () {
        axios.get(`http://localhost/api/soda/${this.$route.params.id}`)
                .then((response) => {
                    this.soda = response.data;
                });
    },

    methods: {
        updateSoda() {
                axios
                    .put(`http://localhost/api/soda/update/${this.$route.params.id}`, this.soda)
                    .then(() => {
                        this.$router.push({name: 'home'});
                    });
            }
    },

    directives: {money: VMoney}
  }
</script>
