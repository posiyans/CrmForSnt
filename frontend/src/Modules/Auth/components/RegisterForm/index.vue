<template>
  <div>
    <q-form
      @submit="handleRegister"
      class="q-gutter-md"
      greedy
      ref="myForm"
    >
      <q-input
        filled
        v-model="form.name"
        label="Имя"
        lazy-rules
        :rules="[ val => val && val.length > 0 || 'Пожалуйста, введите что-нибудь']"
      />
      <q-input
        filled
        v-model="form.email"
        label="E-mail"
        lazy-rules
        :rules="[ required, isEmail ]"
      />
      <q-input
        filled
        :type="showPassword ? '' : 'password'"
        v-model="form.password"
        label="Пароль"
        lazy-rules
        :rules="[
          passwordCapital,
          passwordNumber,
          val => short(val, 8)
        ]"
      />
      <q-input
        filled
        type="password"
        v-model="form.password_confirmation"
        label="Подтвердить пароль"
        lazy-rules
        :rules="[
          val => passwordConfirm(val, form.password)
        ]"
      />
      <div class="row items-center no-wrap">
        <div>
          <q-checkbox v-model="form.personal" />
        </div>
        <div @click="form.personal = !form.personal">
          подтверждаю своё согласие на обработку и передачу информации в электронной Форме (обращения) (в том числе персональных данных) по открытым каналам связи сети Интернет.
          <router-link to="/article/show/term-of-use" class="text-primary">
            Подробнее...
          </router-link>
        </div>
      </div>
      <div>
        <q-btn label="Зарегистрироваться" :loading="authStore.registerLoading" type="submit" :disabled="!form.personal" color="primary" class="full-width" />
      </div>
      <div class="row items-center q-pt-md">
        <div class="q-mr-md">
          или через
        </div>
        <LoginByVkBtn />
      </div>
    </q-form>
  </div>
</template>

<script>
/* eslint-disable */
import { defineComponent, onMounted, reactive, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import LoginByVkBtn from 'src/Modules/SocialMedia/vendors/Vk/components/LoginByVkBtn/index.vue'
import { isEmail, passwordCapital, passwordConfirm, passwordNumber, required, short } from 'src/utils/validators.js'
import { useAuthStore } from 'src/Modules/Auth/store/useAuthStore.js'
import { errorMessage } from 'src/utils/message'
import { useSiteMenuStore } from 'src/Modules/SiteMenu/store/useSiteMenu'

export default defineComponent({
  components: {
    LoginByVkBtn
  },
  props: {},
  setup(props, { emit }) {
    const showPassword = ref(false)
    const myForm = ref(null)
    const form = reactive({
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
      personal: false
    })
    const router = useRouter()
    const route = useRoute()
    const authStore = useAuthStore()
    const siteMenuStore = useSiteMenuStore()
    const handleRegister = () => {
      myForm.value.validate()
        .then(success => {
          if (success) {
            authStore.register(form)
              .then(() => {
                authStore.getMyInfo()
                siteMenuStore.getSiteMenu()
                emit('success')
              })
              .catch(er => {
                console.log(er.response.data.errors)
                errorMessage(er.response.data.message)
                errorMessage(er.response.data.errors)
              })
          }
        })
    }

    onMounted(() => {

    })
    return {
      handleRegister,
      required,
      isEmail,
      short,
      authStore,
      passwordConfirm,
      passwordNumber,
      passwordCapital,
      myForm,
      form,
      showPassword
    }
  }
})
</script>

<style scoped>

</style>
