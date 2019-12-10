<template>

  <v-data-table
    :headers="headers"
    :items="soda"
    class="elevation-1"
    :search="search"
    show-select
    :single-select="singleSelect"
    v-model="selected"
    item-key="_id"
  >
    <template v-slot:top>
      <v-toolbar flat color="white">
        <v-toolbar-title>Estoque de Refrigerante</v-toolbar-title>
        <v-spacer></v-spacer>

        <v-text-field
        v-model="search"
        label="Search"
        single-line
        hide-details
      ></v-text-field>
        <v-spacer></v-spacer>
        <v-dialog v-model="dialog" max-width="500px">
          <template v-slot:activator="{ on }">
             <v-btn depressed class="mx-2" fab small dark color="red" @click="deleteItem(selected)">
                <v-icon>{{icons.mdiDelete}}</v-icon>
             </v-btn>
             <v-btn class="mx-2" fab small dark color="indigo" v-on="on">
                <v-icon dark>mdi-plus</v-icon>
             </v-btn>
          </template>
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
                        v-model="defaultItem.brand"
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
                            v-model="defaultItem.type"
                            outlined
                            :rules="[rules.required]"
                        ></v-select>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                         <v-text-field v-money="money" v-model="defaultItem.unitPrice" outlined :rules="[rules.required]"  label="Preço Unitário"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                        <v-text-field outlined :rules="[rules.required]" v-model="defaultItem.measureValue" label="Valor de Medida"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                        <v-select
                            :items="itemsMeasureUnit"
                            label="Unidade de Medida"
                            v-model="defaultItem.measureUnit"
                            outlined
                            :rules="[rules.required]"
                            required
                        ></v-select>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                        <v-text-field  outlined :rules="[rules.required]" v-model="defaultItem.quantity" type="number" min=0 label="Quantidade"></v-text-field>
                    </v-col>
                    </v-row>
                </v-form>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="close">Cancelar</v-btn>
              <v-btn :disabled="!valid" color="blue darken-1" text @click="save">Salvar</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>
    <template v-slot:item.action="{ item }">
         <router-link
         :to="{name: 'edit', params: { id: item._id }}"
         >
         <v-icon>
             {{ icons.mdiPencil }}
        </v-icon>
        </router-link>
    </template>
    <template v-slot:no-data>
      <v-btn color="primary" @click="initialize">Reset</v-btn>
    </template>
  </v-data-table>
</template>

<script>

  import axios from 'axios';
  import { mdiDelete, mdiPencil } from '@mdi/js'
  import {VMoney} from 'v-money'

  export default {
    data: () => ({
      dialog: false,
      valid: true,
      timeout: 2000,
      singleSelect: false,
      search: '',
      itemsType: ['Pet', 'Garrafa', 'Lata'],
      itemsMeasureUnit: ['mL', 'L'],
      icons: {mdiDelete, mdiPencil},
      loading: true,
      money: {
        decimal: ',',
        thousands: '.',
        prefix: 'R$ ',
        precision: 2,
        masked: true
      },
      rules: {
          required: value => !!value || 'Required.',
        },
      selected: [],
      headers: [
        {
          text: 'Marca',
          align: 'left',
          sortable: false,
          value: 'brand',
        },
        { text: 'Tipo', value: 'type' },
        { text: 'Preço Unitário R$', value: 'unitPrice' },
        { text: 'Litragem', value: 'measureValue' },
        { text: 'Unidade de Medida', value: 'measureUnit'},
        { text: 'Quantidade', value: 'quantity' },
        { text: 'Ação', value: 'action', sortable: false },
      ],
      soda: [],
      defaultItem: {
        brand: '',
        type: '',
        unitPrice: '',
        measureValue: '',
        measureUnit: '',
        quantity: '',
      },
    }),

    watch: {
      dialog (val) {
        val || this.close()
      },
    },

    created () {
      this.initialize()
    },

    methods: {
     async initialize () {
        const request = await axios.get('http://localhost/api/soda');
        this.soda = request.data
      },

       deleteItem (selected) {
        const array = Array.from(selected);
        array.map( item => {
            axios.delete(`http://localhost/api/soda/${item._id}/delete`).then(() => {
                        let i = this.soda.indexOf(item);
                        this.soda.splice(i, 1)
                    });
        })
      },

      close () {
        this.dialog = false
        setTimeout(() => {
          this.defaultItem = Object.assign({}, this.defaultItem)
        }, 300)
      },

       save () {
        axios.post('http://localhost/api/soda/create', this.defaultItem).then(() => {
                this.soda.push(this.defaultItem);
                this.initialize();
        });
        this.close()
      },
    },
    directives: {money: VMoney}
  }
</script>
