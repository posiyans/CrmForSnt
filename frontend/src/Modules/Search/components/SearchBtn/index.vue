<template>
  <div>
    <div class="row ellipsis">
      <transition
        enter-active-class="animated backInRight"
        leave-active-class="animated backOutRight"
      >
        <div
          v-show="inputVisible"
          class="ellipsis"
        >
          <q-input
            ref="inputRef"
            v-model="find"
            dense
            bg-color="white"
            outlined
            @blur="blurForm"
            @keydown.enter="findAction"
          >
            <template v-slot:append>
              <q-icon v-if="find !== ''" name="close" @click="find = ''" class="cursor-pointer" />
              <q-icon name="search" @click="findAction" />
            </template>
          </q-input>
        </div>
      </transition>
      <q-btn v-if="!inputVisible" icon="search" flat @click="showInput" />
    </div>
  </div>
</template>

<script>
/* eslint-disable */
import { defineComponent, ref } from 'vue'
import { useRouter } from 'vue-router'
import { useQuasar } from 'quasar'

export default defineComponent({
  components: {},
  props: {},
  setup(props, { emit }) {
    const inputVisible = ref(false)
    const inputRef = ref(null)
    const data = ref(false)
    const router = useRouter()
    const find = ref('')
    const $q = useQuasar()
    const showInput = () => {
      if ($q.screen.width < 600) {
        router.push('/search')
      } else {
        inputVisible.value = !inputVisible.value
        if (inputVisible.value) {
          setTimeout(() => {
            inputRef.value.focus()
          }, 800)
        }
      }
    }
    const blurForm = () => {
      inputVisible.value = false
    }
    const findAction = () => {
      if (find.value) {
        router.push('/search?find=' + find.value)
      }
      inputVisible.value = false
      find.value = ''
    }
    return {
      data,
      blurForm,
      inputRef,
      inputVisible,
      showInput,
      findAction,
      find
    }
  }
})
</script>

<style scoped lang='scss'>

</style>
