import { ref } from 'vue'

const dontAsk = ref(false)

export function useAdvancedOptions() {
  return {
    dontAsk
  }
}
