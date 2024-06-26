export const adminBookkeeping =
  {
    path: 'bookkeeping',
    meta: {
      icon: 'receipt',
      title: 'Бухгалтерия',
      roles: ['bookkeeping-show', 'profit-show', 'payment-show', 'payment-edit', 'invoice-show', 'invoice-edit', 'rate-edit', 'rate-show']
    },
    redirect: { name: 'adminUserBalance' },
    children: [
      {
        path: 'balance',
        name: 'adminUserBalance',
        component: () => import('src/Modules/Bookkeeping/pages/Balance/AdminBalansList/index.vue'),
        meta: {
          icon: 'receipt',
          title: 'Баланс',
          roles: ['bookkeeping-show']
        }
      },
      {
        path: 'payment_list',
        component: () => import('src/Modules/Bookkeeping/pages/Payment/AdminPaymentList/index.vue'),
        meta: {
          icon: 'receipt',
          title: 'Платежи',
          roles: ['payment-show', 'payment-edit']
        }
      },
      {
        path: 'payment/add',
        component: () => import('src/Modules/Bookkeeping/pages/Payment/PaymentAdd/index.vue'),
        hidden: true,
        meta: {
          icon: 'receipt',
          title: 'Добавить платежи',
          roles: ['payment-edit']
        }
      },
      {
        path: 'invoice',
        component: () => import('src/Modules/Bookkeeping/pages/Invoice/AdminInvoicePrimaryPage/index.vue'),
        meta: {
          icon: 'receipt',
          title: 'Счета',
          roles: ['invoice-show', 'invoice-edit']
        }
      },
      {
        path: 'rate',
        component: () => import('src/Modules/Rate/pages/SettingsRates/index.vue'),
        meta: {
          icon: 'star_rate',
          title: 'Тарифы',
          roles: ['rate-edit', 'rate-show']
        }
      }
    ]
  }
