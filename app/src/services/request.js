import axios from 'axios'
import { API, TOKEN_KEY } from '../../env'
import { get as getIdb } from 'idb-keyval'

axios.interceptors.request.use(async function (config) {
  const token = await getIdb(TOKEN_KEY)

  if (token != null) {
    config.headers.Authorization = `Bearer ${token}`
  }

  return config
}, function (err) {
  return Promise.reject(err)
})

async function post (url, body) {
  return await axios.post(API + url, body)
}
async function get (url, body) {
  return await axios.get(API + url, body)
}

export { post, get }
