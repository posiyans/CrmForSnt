<template>
  <div class="q-pa-sm">
    <div v-if="!authStore.loading">
      <div>
        <div class="flex-md">
          <div class="q-pa-md row justify-center">
            <ChangeMyAvatar />
          </div>
          <div class="col-grow q-col-gutter-sm-md">
            <div class="q-col-gutter-sm-md row-sm">
              <div class="col">
                <InputAndSaveProxy
                  v-model="authStore.user.last_name"
                  label="Фамилия"
                  name="last_name"
                  :func="func"
                  outlined
                  @update:model-value="reloadMyData"
                />
              </div>
              <div class="col q-pt-md">
                <InputAndSaveProxy
                  v-model="authStore.user.name"
                  label="Имя"
                  outlined
                  name="name"
                  :func="func"
                  :rules="[required]"
                  @update:model-value="reloadMyData"
                />
              </div>
              <div class="col">
                <InputAndSaveProxy
                  v-model="user.middle_name"
                  label="Отчество"
                  outlined
                  name="middle_name"
                  :func="func"
                  @update:model-value="reloadMyData"
                />
              </div>
            </div>
            <div class="q-col-gutter-sm-md row-sm">
              <div class="col q-pt-md relative-position">
                <InputAndSaveProxy
                  v-model="authStore.user.email"
                  label="Email"
                  outlined
                  placeholder="Укажите свой электронный ящик"
                  :rules="[isEmail]"
                  name="email"
                  :func="func"
                  @update:model-value="reloadMyData"
                  @errors="showErrors"
                >
                  <template v-slot:append>
                    <div v-if="authStore.user.email && authStore.user.email_verified_at">
                      <q-icon name="verified" color="secondary">
                        <q-tooltip>
                          Email подтвержден
                        </q-tooltip>
                      </q-icon>
                    </div>
                    <div v-else-if="authStore.user.email">
                      <SendVerifyEmailBtn @success="sendSuccess" />
                    </div>
                  </template>
                </InputAndSaveProxy>
              </div>
              <div class="col">
                <InputAndSaveProxy
                  v-model="authStore.user.phone"
                  :func="func"
                  name="phone"
                  @update:modev-value="reloadMyData"
                >
                  <template #default="{ modelValue, setValue }">
                    <InputPhone outlined :model-value="modelValue" label="Телефон" @update:model-value="setValue" />
                  </template>
                </InputAndSaveProxy>
              </div>
              <div class="col q-pt-md">
                <InputAndSaveProxy
                  v-model="authStore.user.telegram"
                  :func="func"
                  name="telegram"
                  @update:modev-value="reloadMyData"
                >
                  <template #default="{ modelValue, setValue }">
                    <q-input
                      :model-value="modelValue"
                      label="Телеграм ID"
                      :loading="loadingTelegram"
                      outlined
                      @update:model-value="setValue"
                    >
                      <template v-slot:append>
                        <GetLastUserIdBtn @setId="setTelegramId" />
                      </template>
                    </q-input>
                  </template>
                </InputAndSaveProxy>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="q-pt-md">
        <div class="text-weight-bold">
          Соц.сети
        </div>
        <SocialMediaList />
      </div>
    </div>
    <User2FaSetting />
  </div>
</template>

<script>
import { defineComponent, onMounted, ref } from 'vue'
import ChangeMyAvatar from 'src/Modules/Avatar/components/ChangeMyAvatar/index.vue'
import InputPhone from 'components/Input/InputPhone/index.vue'
import { useAuthStore } from 'src/Modules/Auth/store/useAuthStore'
import { isEmail, required } from 'src/utils/validators'
import InputAndSaveProxy from 'components/Input/InputAndSaveProxy/index.vue'
import { updateUserFieldData } from 'src/Modules/Users/api/user-admin-api'
import SocialMediaList from 'src/Modules/SocialMedia/components/SocialMediaList/index.vue'
import SendVerifyEmailBtn from 'src/Modules/Auth/components/SendVerifyEmailBtn/index.vue'
import { useQuasar } from 'quasar'
import { errorMessage, successMessage } from 'src/utils/message'
import User2FaSetting from 'src/Modules/Auth/components/User2FaSetting/index.vue'
import GetLastUserIdBtn from 'src/Modules/Telegram/components/GetLastUserIdBtn'

export default defineComponent({
  components: {
    GetLastUserIdBtn,
    User2FaSetting,
    ChangeMyAvatar,
    InputPhone,
    InputAndSaveProxy,
    SocialMediaList,
    SendVerifyEmailBtn
  },
  props: {},
  setup() {
    const $q = useQuasar()
    const func = updateUserFieldData
    const user = ref({})
    const loadingTelegram = ref(false)
    const authStore = useAuthStore()
    const reloadMyData = () => {
      authStore.getMyInfo(true)
    }
    const sendSuccess = () => {
      $q.dialog({
        title: 'Успех',
        message: 'Письмо с сылкой для подтверждения отправлено на указанный вами email. Проверь пожалуйста почту.'
      })
    }
    onMounted(() => {
      user.value = authStore.user
    })
    const showErrors = (error) => {
      errorMessage(error.data.errors)
    }
    const setTelegramId = (val) => {
      loadingTelegram.value = true
      const data = {
        field: 'telegram',
        value: val
      }
      func(data)
        .then(response => {
          successMessage('Телеграм Id обновлен')
        })
        .catch(() => {
          errorMessage('Ошибка при сохранении')
        })
        .finally(() => {
          reloadMyData()
          loadingTelegram.value = false
        })
    }
    return {
      setTelegramId,
      loadingTelegram,
      sendSuccess,
      isEmail,
      required,
      showErrors,
      reloadMyData,
      authStore,
      func,
      user
    }
  }
})
</script>

<style scoped>

</style>
