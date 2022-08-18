<template>
  <q-btn
    color="primary"
    icon="arrow_back"
    dense
    outline
    rounded
    :to="{ name: 'calls' }"
  >
    <q-tooltip :offset="[5, 5]">
      Voltar
    </q-tooltip>
  </q-btn>
  <h4 class="q-mt-lg" v-if="!route.params.id">Criar chamado</h4>
  <h4 class="q-mt-lg" v-else>Editar chamado</h4>
  <q-form
    ref="callForm"
    @submit="submitFunction()"
  >
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-6 q-mr-md">
        <q-input
          label="Título"
          v-model="call.title"
          dense
          outlined
          color="primary"
          :rules="[val => !!val || 'Preenchimento obrigatório']"
        />
      </div>
      <div class="col">
        <q-select
          label="Categoria"
          v-model="call.category"
          :options="categoryOptions"
          dense
          outlined
          map-options
          emit-value
          option-label="label"
          option-value="value"
          color="primary"
          :rules="[val => !!val || 'Preenchimento obrigatório']"
        />
      </div>
    </div>
    <div class="col q-mb-lg">
      <q-input
        label="Descrição"
        v-model="call.description"
        dense
        outlined
        autogrow
      />
    </div>
    <div align="right">
      <q-btn
        outline
        :label="!route.params.id ? 'Criar chamado' : 'Editar chamado'"
        :icon="!route.params.id ? 'save' : 'edit'"
        type="submit"
        color="primary"
        :disable="saving"
        :loading="saving"
      />
    </div>
  </q-form>
</template>

<script setup>
import { onMounted, reactive, ref } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { createCall, updateCall, getCall } from 'src/services/call/call-api'
import { Notify, Loading } from 'quasar'
import { formatResponseError } from "src/services/utils/error-formatter";
import { loggedUser } from "boot/user"
import { t } from 'src/services/utils/i18n'

const call = ref({})

const categoryOptions = [
  {
    label: 'Criação Usuário',
    value: 'create_user',
  },
  {
    label: 'Impressora',
    value: 'printer',
  },
  {
    label: 'Hardware',
    value: 'hardware',
  },
  {
    label: 'Software',
    value: 'software',
  },
  {
    label: 'Rede',
    value: 'network',
  }
]

let abilitiesCache = ref([])
let saving = ref(false)

const callForm = ref(null)
const router = useRouter()
const route = useRoute()

onMounted(async () => {
  if (route.params.id) {
    await getCallFunction()
  }
})

async function submitFunction() {
  saving.value = true
  try {
    const validated = callForm.value.validate()
    if (validated) {
      call.value.user_id = loggedUser.id
      const callToSave = { ...call.value }
      !route.params.id ? await createCall(callToSave) : await updateCall(route.params.id, callToSave)

      Notify.create({
        message: !route.params.id ? 'Chamado criada com sucesso!' : 'Chamado editada com sucesso!',
        type: 'positive'
      })

      router.push({ name: 'calls' })
    }
  } catch (error) {
    Notify.create({
        message: formatResponseError(error) || 'Falha ao salvar chamado',
        type: 'negative'
    })
  }
  saving.value = false
}

async function getCallFunction() {
  Loading.show()
  try {
    const response = await getCall(route.params.id)
    abilitiesCache.value = response.abilities || []
    call.value = response
  } catch (e) {
    Notify.create({
      message: 'Falha ao buscar chamado!',
      type: 'negative'
    })
  }
  Loading.hide()
}
</script>

<style scoped>

</style>
