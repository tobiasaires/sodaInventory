<template>
  <v-data-table
    :headers="headers"
    :items="soda"
    class="elevation-1"
    :search="search"
    show-select
    :single-select="singleSelect"
    v-model="selected"
    item-key="brand"
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
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text>
              <v-container>
                <v-row>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field v-model="editedItem.brand" label="Marca"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field v-model="editedItem.type" label="Tipo"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field v-model="editedItem.unitPrice" label="Preço Unitário"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field v-model="editedItem.measureType" label="Valor de Medida"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field v-model="editedItem.measureUnit" label="Unidade de Medida"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field v-model="editedItem.quantity" label="Quantidade"></v-text-field>
                  </v-col>
                </v-row>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
              <v-btn color="blue darken-1" text @click="save">Save</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>
    <template v-slot:item.action="{ item }">
      <v-btn
        small
        depressed
        fab
        class="mr-2"
        color="white"
        @click="editItem(item)"
      >
        <v-icon>{{ icons.mdiPencil }}</v-icon>
      </v-btn>
    </template>
    <template v-slot:no-data>
      <v-btn color="primary" @click="initialize">Reset</v-btn>
    </template>
  </v-data-table>
</template>

<script>

  import { mdiDelete, mdiPencil } from '@mdi/js'
  export default {
    data: () => ({
      dialog: false,
      singleSelect: false,
      search: '',
      icons: {mdiDelete, mdiPencil},
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
        { text: 'Litragem', value: 'measure' },
        { text: 'Quantidade', value: 'quantity' },
        { text: 'Actions', value: 'action', sortable: false },
      ],
      soda: [],
      editedIndex: -1,
      editedItem: {
        brand: '',
        type: '',
        unitPrice: 0,
        measureValue: '',
        measureUnit: 0,
        quantity: 0,
      },
      defaultItem: {
        brand: '',
        type: '',
        unitPrice: 0,
        measureValue: '',
        measureUnit: 0,
        quantity: 0,
      },
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'Novo' : 'Editar'
      },
      disableButton() {
        return this.selected == 0 ? true : false;
      }
    },

    watch: {
      dialog (val) {
        val || this.close()
      },
    },

    created () {
      this.initialize()
    },

    methods: {
      initialize () {
        this.soda = [
          {
            _id: "5deb035e83b9b6000f356d5a",
            brand: "Coca Cola",
            type: "Pet",
            unitPrice: "5.00",
            quantity: 2,
            measure: "5003214111100 mL",
            updated_at: "2019-12-07 00:42:38",
            created_at: "2019-12-07 00:42:38"
          },
          {
            _id: "asjkdhkadjh",
            brand: "Coca  Cola",
            type: "Pet",
            unitPrice: "5.00",
            quantity: 1,
            measure: "5003214111100 mL",
            updated_at: "2019-12-07 00:42:38",
            created_at: "2019-12-07 00:42:38"
          },

        ]
      },

      editItem (item) {
        this.editedIndex = this.soda.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (selected) {
        // const index = this.soda.indexOf(item)
        // confirm('Are you sure you want to delete this item?') && this.soda.splice(index, 1)

        console.log(selected);
      },

      close () {
        this.dialog = false
        setTimeout(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        }, 300)
      },

      save () {
        if (this.editedIndex > -1) {
          Object.assign(this.soda[this.editedIndex], this.editedItem)
        } else {
          this.soda.push(this.editedItem)
        }
        this.close()
      },
    },
  }
</script>
