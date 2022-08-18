import { get, post, put, destroy } from 'boot/axios'

export const getCalls = async (params = { page: '', rowsPerPage: 0 }) => {
  params.perPage = params.rowsPerPage || 0
  const { data } = await get('/calls', params)
  params.rowsNumber = data.total
  return data.data
}

export const getCall = async (id, params) => {
  const { data } = await get(`/calls/${id}`, params)
  return data
}

export const createCall = async call => {
  const { data } = await post('/calls', call)
  return data
}

export const updateCall = async (id, call) => {
  const { data } = await put(`/calls/${id}`, call)
  return data
}

export const destroyCall = async id => {
  await destroy(`/calls/${id}`)
}

export const getAllCall = async ()=> {
   const { data } = await get('/calls/all-call')
   return data
 }
