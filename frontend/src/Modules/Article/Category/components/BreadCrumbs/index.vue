<template>
  <div class="row items-center bread-crumbs-block">
    <ItemBlock
      v-for="item in findItem"
      :key="item.id"
      :item="item"
    />
  </div>
</template>

<script>
/* eslint-disable */
import { computed, defineComponent, ref } from 'vue'
import { useSiteMenuStore } from 'src/Modules/SiteMenu/store/useSiteMenu'
import ItemBlock from './components/ItemBlock/index.vue'

export default defineComponent({
  components: {
    ItemBlock
  },
  props: {
    categoryId: {
      type: [String, Number],
      default: ''
    },
    addMain: {
      type: Boolean,
      default: false
    }
  },
  setup(props, { emit }) {
    const data = ref(false)
    const siteMenuStore = useSiteMenuStore()
    const findItem = computed(() => {
      if (props.categoryId && siteMenuStore.menu) {
        const tmp = []
        if (props.addMain) {
          tmp.push({ label: 'Главная' })
        }
        findId(+props.categoryId, siteMenuStore.menu).forEach(item => {
          tmp.push(item)
        })
        return tmp
      }
      return false
    })
    const findId = (id, object) => {
      const rez = [];
      object.forEach(item => {
        const parent = {
          id: item.id,
          label: item.label
        }
        if (item.id === id) {
          rez.push(parent)
        } else if (item.children) {
          const tmp = findId(id, item.children)
          if (tmp.length > 0) {
            rez.push(parent)
            tmp.forEach(i => {
              rez.push(i)
            })
          }
        }
        return false
      })
      return rez
    }

    return {
      data,
      siteMenuStore,
      findItem
    }
  }
})
</script>

<style scoped lang='scss'>
.bread-crumbs-block div:not(:last-child):after {
  content: '>';
  opacity: .6;
  margin-right: 5px;
  margin-left: 5px;
}
</style>
