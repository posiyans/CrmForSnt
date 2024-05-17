import { ref } from 'vue'

export function useAppealStatus() {
  const status = ref([
    {
      value: 'open',
      label: 'Открытый',
      color: 'text-red',
      icon: 'lock_open'
    },
    {
      value: 'close',
      label: 'Закрытый',
      color: 'text-teal',
      icon: 'lock_outline'
    }
  ])
  return {
    status
  }
}
