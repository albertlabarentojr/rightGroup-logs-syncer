import {defineAsyncComponent} from 'vue'

const Table = {
  List: defineAsyncComponent(() => import('./table/List.vue')),
  Pagination: defineAsyncComponent(() => import('./table/Pagination.vue')),
}

const Dashboard = {
  CounterWidget: defineAsyncComponent(() => import('./dashboard/CounterWidget.vue')),
}

const Form = {
  Select: defineAsyncComponent(() => import('./form/Select.vue')),
  Text: defineAsyncComponent(() => import('./form/Text.vue')),
  Datepicker: defineAsyncComponent(() => import('./form/Datepicker.vue')),
  DateRangePicker: defineAsyncComponent(() => import('./form/DateRangePicker.vue')),
}

const Button = {
  Default: defineAsyncComponent(() => import('./button/Default.vue')),
}

export default {
  Table,
  Dashboard,
  Form,
  Button,
}
