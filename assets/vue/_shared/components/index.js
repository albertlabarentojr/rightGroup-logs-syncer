import { defineAsyncComponent } from 'vue'

const Table = {
  List: defineAsyncComponent(() => import('./table/List.vue')),
  Pagination: defineAsyncComponent(() => import('./table/Pagination.vue'))
}
const Dashboard = {
   CounterWidget: defineAsyncComponent(() => import('./dashboard/CounterWidget.vue')),
}

export default {
  Table,
  Dashboard,
}
