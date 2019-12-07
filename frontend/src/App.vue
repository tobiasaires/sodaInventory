<template>
  <v-app>
      <SodaComponent />
  </v-app>
</template>

<script>
import SodaComponent from './components/SodaComponent';

export default {
  name: 'App',

  components: {
    SodaComponent,
  },

  data: () => ({
    //
  }),
};
</script>
