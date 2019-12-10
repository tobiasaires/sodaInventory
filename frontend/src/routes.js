import SodaComponent from "./components/SodaComponent.vue";
import EditSoda from "./components/EditSoda.vue";

export const routes = [
    {
        name: "home",
        path: "/",
        component: SodaComponent
    },
    {
        name: "edit",
        path: "/edit/:id",
        component: EditSoda
    }
];
