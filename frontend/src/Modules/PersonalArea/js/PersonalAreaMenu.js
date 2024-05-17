export function getMenu() {
  const menu = [
    {
      label: 'Личный кабинет',
      children: [
        {
          label: 'Счета и платежи',
          path: '/personal-area/invoice',
          icon: 'add'
        },
        {
          label: 'Показания',
          path: '/personal-area/instrument-reading',
          icon: 'add'
        },
        {
          label: 'Обращения',
          path: '/personal-area/appeal',
          icon: 'add'
        },
        {
          label: 'Собственник',
          path: '/personal-area/owner',
          icon: 'add'
        },
        {
          label: 'Участок',
          path: '/personal-area/stead',
          icon: 'add'
        }
      ]
    }
  ]
  return menu
}
