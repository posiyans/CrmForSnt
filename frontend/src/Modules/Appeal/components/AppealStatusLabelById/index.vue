<template>
  <div :class="className">
    <q-icon v-if="icon" :name="iconName">
      <q-tooltip>
        {{ label }}
      </q-tooltip>
    </q-icon>
    <span v-if="!icon">
      {{ label }}
    </span>
  </div>
</template>

<script>
/* eslint-disable */
import { computed, defineComponent, ref } from 'vue'
import { useAppealStatus } from 'src/Modules/Appeal/hooks/useAppealStatus'

export default defineComponent({
  components: {},
  props: {
    status: {
      type: String,
      default: ''
    },
    icon: {
      type: Boolean,
      default: false
    },
    addColor: {
      type: Boolean,
      default: false
    }
  },
  setup(props, { emit }) {
    const data = ref(null)
    const { status } = useAppealStatus()
    const typeObj = computed(() => {
      return status.value.find(item => {
        if (item.value === props.status) {
          return true
        }
      })
    })
    const label = computed(() => {
      return typeObj?.value?.label || ''
    })
    const iconName = computed(() => {
      return typeObj?.value?.icon || ''
    })
    const className = computed(() => {
      if (props.addColor) {
        return typeObj?.value?.color || ''
      }
      return ''
    })
    return {
      data,
      label,
      iconName,
      className,
      typeObj
    }
  }
})
</script>

<style scoped>

</style>
