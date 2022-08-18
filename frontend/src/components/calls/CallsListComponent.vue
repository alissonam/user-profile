<template>
  <q-table
    title="Chamados"
    :rows="callsData"
    :columns="columns"
    row-key="id"
    v-model:pagination="mainPagination"
    :loading="loading"
    loading-label="Carregando..."
    no-results-label="Nenhum chamado encontrada"
    no-data-label="Nenhum chamado encontrada"
    binary-state-sort
    @request="getCallsFunction"
  >
    <template v-slot:top-right>
      <q-btn
        icon="add"
        label="Adicionar"
        color="primary"
        outline
        :to="{ name: 'calls_create' }"
      />
    </template>
    <template v-slot:body-cell-actions="props">
      <q-td key="actions" :props="props">
        <q-btn-group outline>
          <!--<q-btn
            outline
            color="primary"
            icon="edit"
            :to="{ name: 'calls_update', params: { 'id': props.row.id } }"
          >
            <q-tooltip>
              Editar
            </q-tooltip>
          </q-btn>
          -->
          <q-btn
            outline
            color="negative"
            icon="delete"
            :loading="removing"
            :disable="removing"
            @click="destroyCallFunction(props.row.id)"
          >
            <q-tooltip>
              Excluir
            </q-tooltip>
          </q-btn>
        </q-btn-group>
      </q-td>
    </template>
  </q-table>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { getCalls, destroyCall } from 'src/services/call/call-api'
import { loggedUser } from "boot/user"
import { Notify, Dialog } from 'quasar'
import { t } from 'src/services/utils/i18n'

let callsData = ref([])
let loading = ref(false)
let removing = ref(false)

const mainPagination = ref({
  page: 1,
  rowsPerPage: 10,
  rowsNumber: 0,
})

const columns = [
  {
    name: 'title',
    label: 'Título',
    align: 'left',
    field: 'title',
    format: val => val || 'N/I',
  },
  {
    name: 'category',
    label: 'Categoria',
    align: 'left',
    field: 'category',
    format: val => t(`categories.${val}`) || 'N/I',
  },
  {
    name: 'description',
    label: 'Descrição',
    align: 'left',
    field: 'description',
    format: val => val || 'N/I',
  },
  {
    name: 'actions',
    align: 'center',
    label: 'Ações',
    field: 'id',
    sortable: false
  },
]

onMounted(async () => {
  await getCallsFunction()
})

async function getCallsFunction(props) {
  loading.value = true
  try {
    mainPagination.value = props?.pagination || mainPagination.value
    callsData.value = await getCalls(mainPagination.value)

    if (loggedUser.role === 'member') {
      callsData.value.filter(call => {
        return call.user_id === loggedUser.id
      })
    }
  } catch (e) {
    Notify.create({
      message: 'Falha ao buscar chamados!',
      type: 'negative'
    })
  }
  loading.value = false
}

async function destroyCallFunction(call) {
  Dialog.create({
    title: 'Atenção!',
    message: 'Tem certeza que deseja excluir esta chamado?',
    cancel: true,
  }).onOk(async () => {
    removing.value = true
    try {
      await destroyCall(call)
      getCallsFunction()

      Notify.create({
        message: 'Chamado excluída com sucesso!',
        type: 'positive'
      })
    } catch (e) {
      Notify.create({
        message: 'Falha ao excluir chamado!',
        type: 'negative'
      })
    }
    removing.value = false
  })
}
</script>
