<script>
import { defineComponent, h } from 'vue'
import { QBtn, QBtnDropdown, QExpansionItem, QItem, QItemSection, QList } from 'quasar'
import ItemMenu from './ItemMenu.vue'
import { isExternal } from 'src/utils/validators'

export default defineComponent({
  props: {
    item: {
      type: Object
    },
    first: {
      type: Boolean,
      default: false
    },
    icon: {
      type: Boolean,
      default: false
    },
    uclass: {
      type: String,
      default: ''
    },
    parentKey: {
      type: Number,
      default: 0
    }
  },
  setup(props) {
    const render = () => {
      if (props.first) {
        return renderHeaderBtn
      }
      return renderMenu
    }
    const renderHeaderBtn = () => {
      const vnode = {
        chld: null,
        props: {
          label: props.item.label,
          noCaps: true,
          flat: true,
          square: true,
          menuAnchor: 'bottom left',
          menuSelf: 'top left',
          menuOffset: [0, 8],
          contentClass: 'no-border-radius '
        },
        type: QBtn
      }
      if (props.icon && props.item.meta?.icon) {
        vnode.props.icon = props.item?.icon
      }
      if (props.item.children && props.item.children.length > 0) {
        vnode.type = QBtnDropdown
        const tmp = []
        const nextKey = props.parentKey + 1
        props.item.children.forEach(child => {
          tmp.push(h(ItemMenu, { item: child, parentKey: nextKey, icon: props.icon }))
        })
        vnode.chld = h(QList, {}, () => tmp)
      }
      if (props.item.path) {
        vnode.props.to = props.item.path
      }
      return h(vnode.type, vnode.props, () => vnode.chld)
    }
    const renderMenu = () => {
      const itemProps = {
        clickable: true,
        to: props.item.path
      }
      if (props.icon && props.item?.icon) {
        itemProps.icon = props.item?.icon
      }
      const propsObject = {
        clickable: true
      }
      if (isExternal(props.item.path)) {
        propsObject.onClick = () => window.open(props.item.path)
      } else {
        propsObject.to = props.item.path
      }
      let l = h(QItem, propsObject, () => h(QItemSection, { class: props.uclass }, () => props.item.label))
      const nextKey = props.parentKey + 1
      if (props.item.children && props.item.children.length > 0) {
        const tmp = []
        props.item.children.forEach(child => {
          tmp.push(h(ItemMenu, { item: child, parentKey: nextKey, icon: props.icon, uclass: 'user-site-menu-item' }))
        })
        const icon = props.item.meta?.icon
        l = [h(QExpansionItem,
          {
            switchToggleSide: false,
            label: props.item.label,
            icon,
            group: 'menu_' + props.parentKey,
            expandIconClass: 'site-menu'
          },
          () => h(QList, {}, () => tmp))
        ]
      }
      return l
    }
    return render()
  }
})
</script>

<style lang='scss'>
// todo переделать имя класса

.user-site-menu-item {
  margin-left: 5px;
  padding-left: 0px;
  font-size: 0.85em;
  opacity: 0.8;
  //border-left: 1px solid rgba(0, 0, 0, .12);
}
</style>
