<script>
/* eslint-disable */
import { defineComponent, h } from 'vue'
import GardeningRequisite from 'src/Modules/Gardening/components/GardeningRequisite/index.vue'

export default defineComponent({
  components: {
    GardeningRequisite
  },
  props: {
    text: {
      type: String,
      default: ''
    }
  },
  setup(props) {

    const blocks = {
      // '[block-1]': GardeningRequisite
    }

    const getChildren = (val) => {
      const props = {}
      if (val.attributes?.length > 0) {
        for (let i = 0; i < val.attributes?.length; i++) {
          const attribute = val.attributes[i]
          props[attribute.localName] = attribute.value
        }
      }
      const children = []
      Object.values(val.childNodes).forEach(node => {
        children.push(getChildren(node))
      })
      if (val.nodeName === '#text') {
        if (Object.keys(blocks).includes(val.textContent)) {
          val.localName = blocks[val.textContent]
        } else {
          return val.textContent
        }
      }
      return h(val.localName, props, children)
    }
    const render = () => {
      const parser = new DOMParser();
      const document = parser.parseFromString(props.text, "text/html");
      const tmp = []
      Object.values(document.documentElement.children[1].children).forEach(item => {
        tmp.push(getChildren(item))
      })
      return h('div', tmp)
    }
    return render
  }
})
</script>

<style scoped lang='scss'>

</style>
